<template>
    <TopButton title="EVENT" />
    <div class="event">
        <h2>★ 이벤트 참여하고 환경 포인트 받자! ★</h2>
        <img src="../assets/img/event1.png" alt="event1" width="100%" />
        <p>
            자사 제품 사용 후 남은 공병을 보내주시면 <br />
            월 최대 6개로 개당 <span>500</span> 환경포인트를 드립니다.
        </p>
    </div>
    <div class="event">
        <h2>★ 사막을 푸르게 <span>지구를 건강하게</span> ★</h2>
        <img src="../assets/img/event2.png" alt="event2" width="100%" />
        <p>
            자사브랜드 제품을 구매하여 고객님의 <br />
            이름으로 나무심기 이벤트에 동참해주세요!
        </p>
    </div>
    <div class="event">
        <h2>★ 2025년 <span>뱀띠</span>를 찾습니다! ★</h2>
        <img src="../assets/img/event3.png" alt="event3" width="100%" />
        <p>
            2025년 푸른뱀에 해가 밝았습니다! <br />
            뱀띠의 해당하는 고객님은 간단한 인증 후 <br />
            일정의 환경 포인트를 선물로 드립니다.
        </p>
    </div>
    <div class="margin"></div>
</template>
<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'event',
    components: {
        TopButton
    }
};
</script>

<style scoped>
h2 {
    margin: 35px 0px 15px;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    letter-spacing: -1px;
}
.event img {
    width: 100%;
}

.event p {
    font-size: 14px;
    line-height: 24px;
    text-align: center;
    margin-top: 15px;
}

.margin {
    height: 67px;
}
</style>
