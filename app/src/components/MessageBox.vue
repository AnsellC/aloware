<template>
    <transition name="fade">
        <div
            v-if="visible"
            :class="[
                {
                    'bg-red-500 border-red-500': type === 'ERROR',
                    'bg-blue-500 border-blue-500': type !== 'ERROR',
                },
                'border-t-4',
                'rounded-b',
                'text-white',
                'px-4',
                'py-3',
                'shadow-md',
            ]"
            role="alert"
            style="position: fixed; bottom: 0px; width: 100%"
            ref="box"
        >
            <p class="font-bold" v-html="message"></p>
        </div>
    </transition>
</template>
<script lang="ts">
import { Component } from 'vue-property-decorator';
import BaseClass from '../base';

type MessageData = {
    type: 'ERROR' | 'SUCCESS';
    message: string;
};

@Component
export default class BoxComponent extends BaseClass {
    $refs!: {
        box: HTMLDivElement;
    };

    type = 'ERROR';
    message = '';
    visible = false;

    created() {
        this.$root.$on('MESSAGE_BOX', (data: MessageData) => {
            this.message = data.message;
            this.type = data.type;
            this.visible = true;

            setTimeout(() => {
                this.visible = false;
            }, 5000);
        });
    }
}
</script>
