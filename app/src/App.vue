<template>
    <div id="app">
        <div class="bg-indigo-800 p-3 text-center mb-16">
            <h1 class="text-3xl font-bold text-slate-50">
                Aloware Test Project
            </h1>
        </div>
        <div class="container mx-auto bg-white p-8">
            <router-view />
        </div>
        <message-box></message-box>
    </div>
</template>
