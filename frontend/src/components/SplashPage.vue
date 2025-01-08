<template>
    <div class="splash-container" :class="{ 'fade-out': fadeOut }">
        <div class="splash-content">
            <h1><img :src="require('@/assets/img/NEDE_logo.png')" alt="logo" /></h1>
        </div>
    </div>
</template>
<script>
export default {
    name: 'SplashPage',
    props: {
        fadeOut: {
            type: Boolean, // Boolean은 참 거짓을 나타냄
            default: false
        }
    }
};
</script>
<style scoped>
.splash-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 1;
    transition: opacity 1s ease-in-out;
}

.splash-container.fedeout {
    opacity: 0;
}

.splash-content {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
}

h1 img {
    width: 80px;
    height: auto;
}
</style>
