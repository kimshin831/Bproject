<template>
    <SplashPage v-if="showSplash" />
    <router-view />
    <footerFix />
</template>
<script>
import footerFix from './components/footerFix.vue';
import { ref, onMounted } from 'vue';
import SplashPage from './components/SplashPage.vue';

export default {
    name: 'NEDE',
    components: {
        footerFix,
        SplashPage
    },
    setup() {
        const showSplash = ref(true); // 반응형 변수로 선언
        // 스플래시 페이지를 일정시간 후에 숨김
        onMounted(() => {
            // 컴포넌트가 DOM에 마운트된 후 실행
            setTimeout(() => {
                showSplash.value = false;
            }, 3000);
        });
        return {
            showSplash
        };
    }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap');
#app {
    font-family: 'Noto Sans', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>
