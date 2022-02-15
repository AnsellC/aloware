<template>
    <div class="py-6 divide-y">
        <form ref="form" @submit.prevent="post()">
            <input
                type="text"
                placeholder="Name"
                v-model="name"
                class="form-control block w-full p-2 mb-2 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            />
            <textarea
                v-model="comment"
                placeholder="Write a comment..."
                class="form-control block w-full p-4 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            ></textarea>
            <button
                type="submit"
                class="my-2 w-full bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none"
            >
                Post comment
            </button>
        </form>
    </div>
</template>
<script lang="ts">
import { Component, Prop } from 'vue-property-decorator';
import BaseClass from '../base';

@Component
export default class CommentBoxComponent extends BaseClass {
    @Prop(Number) readonly parentId!: number;
    name = '';
    comment = '';
    loading = false;

    $refs!: {
        form: HTMLFormElement;
    };

    async post() {
        this.loading = true;
        try {
            const response = await fetch(
                `${this.config.api_endpoint}/comments`,
                {
                    method: 'POST',
                    body: JSON.stringify({
                        name: this.name,
                        comment: this.comment,
                        parent_id: this.parentId,
                    }),
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                }
            );
            const json = await response.json();
            if (!response.ok) {
                throw new Error(json.message);
            }

            this.$root.$emit('MESSAGE_BOX', {
                type: 'SUCCESS',
                message: 'Comment posted successfully.',
            });

            this.$root.$emit('RELOAD_COMMENT');
            this.$emit('close');
        } catch (error) {
            this.$root.$emit('MESSAGE_BOX', {
                type: 'ERROR',
                message: error.message,
            });
        }
    }
}
</script>
