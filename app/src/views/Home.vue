<template>
    <div class="home">
        <h2 class="text-blue-800 text-4xl font-bold">This is a sample post</h2>
        <div class="p-4 text-gray-400 text-sm">
            Posted by <strong>Admin</strong>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 ml-1"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                style="display: inline"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
            Feb 14, 2022
        </div>
        <div class="p-4 text-gray-500 text-lg">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                tristique quam id orci consectetur, non rutrum orci finibus.
                Praesent a dolor ultrices, sollicitudin justo ac, pharetra nibh.
                Donec sit amet accumsan magna. In non lacus lorem. Aliquam
                sodales, metus sit amet euismod commodo, nisl est vestibulum
                orci, ut dignissim sapien libero in augue. Aenean non felis at
                velit imperdiet dapibus. Sed ac rhoncus ex. Pellentesque sit
                amet nisl nulla. Aliquam accumsan diam diam. Aenean laoreet,
                nisl ut interdum interdum, odio felis pharetra dolor, eu luctus
                eros est non erat. Fusce consequat id mauris eu egestas. Aenean
                nec enim lacinia nulla faucibus cursus vestibulum a sapien.
                Aliquam ac est non elit suscipit faucibus non molestie tellus.
            </p>
        </div>

        <comment-box :parent-id="null"></comment-box>

        <comment
            v-for="comment in comments"
            :key="comment.id"
            :comment="comment"
        ></comment>
    </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import BaseClass from '../base';
import _ from 'lodash';

type Comment = {
    parent_id: number | null;
    id: number;
    depth: number;
    name: string;
    comment: string;
    created_at: string;
    updated_at: string;
    children: Comment[];
};

@Component
export default class Home extends BaseClass {
    comments: Array<Comment> = [];

    async created() {
        this.$root.$on('RELOAD_COMMENT', () => {
            this.loadComments();
        });
        this.loadComments();
    }

    private async loadComments() {
        const response = await fetch(`${this.config.api_endpoint}/comments`);
        const data = await response.json();
        this.comments = [];
        this.comments.push(
            ...data.data.map((i) => {
                return {
                    ...i,
                    children: [],
                };
            })
        );
        this.processComments();
    }

    processComments() {
        // Process comments on a fixed depth. Typically, one would use a combination of reduce and map
        // or a recursive function to process comments. But for this example, a for loop will be sufficient.
        for (let i = 3; i > 1; i--) {
            this.comments
                .filter((x) => x.depth === i)
                .forEach((comment) => {
                    const parent = this.comments.find(
                        (x) => x.id === comment.parent_id
                    );
                    if (parent) {
                        parent.children.push(comment);
                        this.comments.splice(this.comments.indexOf(comment), 1);
                    }
                });
        }
    }
}
</script>
