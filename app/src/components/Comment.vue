<template>
    <div
        :class="[
            'rounded-lg my-2 mb-6 p-4 border-2 comment-box',
            {
                'border-slate-100': comment.depth >= 3,
                'border-slate-200': comment.depth === 2,
                'border-slate-300': comment.depth == 1,
            },
        ]"
    >
        <div class="flex justify-between">
            <div class="flex items-center">
                <img
                    class="inline object-cover w-6 h-6 rounded-full bg-slate-600 mr-2"
                    :src="`https://i.pravatar.cc/150?u=${comment.name}`"
                />
                <span class="text-lg font-bold text-red-400 mr-1">
                    {{ comment.name }} {{ comment.depth }}
                </span>
                <span class="text-gray-400 text-sm">
                    {{ comment.created_at | dateFromNow }}
                </span>
            </div>
            <div class="reply-button" v-if="comment.depth < 3">
                <button
                    @click="replyBox = true"
                    class="hover:text-gray-500 text-gray-400 font-bold py-2 px-4 rounded inline-flex items-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </div>
        </div>

        <span class="text-gray-400 text-sm mr-2">&#8212;</span>
        <span class="text-gray-500 text-lg">{{ comment.comment }}</span>
        <comment-box
            @close="replyBox = false"
            v-if="replyBox"
            :parent-id="comment.id"
        ></comment-box>

        <!--children-->
        <template v-if="comment.children.length > 0">
            <comment
                v-for="childComment in comment.children"
                :key="childComment.id"
                :comment="childComment"
            ></comment>
        </template>
    </div>
</template>
<script lang="ts">
import { Component, Prop } from 'vue-property-decorator';
import BaseClass from '../base';
import _ from 'lodash';

@Component
export default class CommentComponent extends BaseClass {
    replyBox = false;
    @Prop({ required: true }) readonly comment!: Comment;
}
</script>
