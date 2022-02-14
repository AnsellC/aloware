<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_post_a_comment()
    {
        $name = $this->faker->firstName();
        $comment = $this->faker->paragraph();
        $response = $this->json('POST', '/api/comments', [
            'comment' => $comment,
            'name' => $name,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'comment' => $comment,
            'name' => $name,
        ]);
    }

    /** @test */
    public function a_user_can_reply_to_a_comment()
    {
        $name = $this->faker->firstName();
        $comment = $this->faker->paragraph();
        $response = $this->json('POST', '/api/comments', [
            'comment' => $comment,
            'name' => $name,
        ]);


        $commentId = $response->json('data.id');
        $childCommentResponse = $this->json('POST', '/api/comments', [
            'comment' => $comment,
            'name' => $name,
            'parent_id' => $commentId,
        ]);

        $this->assertEquals($childCommentResponse->json('data.parent_id'), $commentId);
    }

    /** @test */
    public function a_comment_can_only_go_three_levels_deep()
    {
        $parentId = null;
        $shouldError = false;

        for ($i = 1; $i <= 5; $i++) {
            $name = $this->faker->firstName();
            $comment = $this->faker->paragraph();

            $payload = [
                'comment' => $comment,
                'name' => $name,
            ];

            if ($parentId) {
                $payload['parent_id'] = $parentId;
            }

            $response = $this->json('POST', '/api/comments', $payload);
            if ($shouldError) {
                $response->assertStatus(422);
            } else {
                $response->assertStatus(201);
            }


            if ($response->json('data.depth') > 3) {
                $shouldError = true;
            }


            $parentId = $response->json('data.id');
        }
    }

    /** @test */
    public function anyone_can_see_the_comments()
    {
        // generate 5 comments via json POST
        for ($i = 1; $i <= 5; $i++) {
            $name = $this->faker->firstName();
            $comment = $this->faker->paragraph();

            $payload = [
                'comment' => $comment,
                'name' => $name,
            ];

            $this->json('POST', '/api/comments', $payload);
        }

        // check if we have 5 comments

        $response = $this->json('GET', '/api/comments');
        dd($response->json());
    }
}
