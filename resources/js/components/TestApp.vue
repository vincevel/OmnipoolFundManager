<template>
<div class="flex flex--column flex--align-center flex--justify-center">
    <div class="logos">
    </div>

    <div class="title">
        <h1 class="vue">Vue 3</h1>
            {{ count }}
        <h1 class="plus">+</h1>
        <input type="text" v-model.number="incrementnum">
        <h1 class="laravel">Laravel 8</h1>
        <button @click="$store.commit('INCREMENT',this.incrementnum)">Increment</button>
    </div>
</div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    mounted() {
        console.log("Component mounted.");
    },
    computed: {
        ...mapState({
            count: state => state.count
        }),
    }
};
</script>

<style lang="scss">
html,
body,
#app {
    width: 100%;
    height: 100%;
    font-family: Arial, Helvetica, sans-serif;
    background: #e3e4e5;
}

.flex {
    display: flex;
    height: 100%;
    width: 100%;

    &--column {
        flex-direction: column;
    }

    &--align-center {
        align-items: center;
    }

    &--justify-center {
        justify-content: center;
    }
}

.logos {
    padding-top: 16px;
    display: grid;
    grid-template-columns: auto auto;
    grid-gap: 32px;
}

.title {
    display: grid;
    grid-template-columns: auto auto auto;
    grid-gap: 16px;
    padding: 32px;

    .laravel {
        color: #ff291a
    }

    .vue {
        color: #41b883;
    }

    .plus {
        color: #35495e
    }

}
</style>
