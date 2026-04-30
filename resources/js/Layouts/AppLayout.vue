<template>
    <main>
       <NavBar />
        <slot />
        <h1>Footer</h1>
    </main>
</template>

<script>
import NavBar from './NavBar.vue';


export default {
    components:{
        NavBar
    }

}
</script>

<style></style>