<template>
    <div class="container">
        <TopButton title="주문완료" />
        <div class="order-complete-container">
            <div class="order">
                <h1>주문이 완료되었습니다!</h1>
                <p>주문해주셔서 감사합니다.</p>
                <p>주문번호 : 3548798754684241</p>
                <button class="btns">주문상세보기</button>
                <button @click="goToMain" class="btns">메인으로 이동</button>
            </div>
            <div class="complete">
                <p>
                    총 결제 금액: <strong>{{ totalAmount.toLocaleString() }} 원</strong>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import TopButton from '@/components/TopButton.vue';
export default {
    name: 'OrderComplete',
    components: { TopButton },
    data() {
        return {
            totalAmount: 0 // 총 결제 금액 저장
        };
    },
    created() {
        // query로 전달된 총 결제 금액 수신
        const totalQuery = this.$route.query.total;
        if (totalQuery && !isNaN(totalQuery)) {
            this.totalAmount = parseInt(totalQuery, 10); // 문자열을 숫자로 변환
        } else {
            console.warn('총 결제 금액 데이터가 없습니다.');
            this.totalAmount = 0; // 기본값 설정
        }
    },
    methods: {
        goToMain() {
            this.$router.push('/'); // 메인 페이지로 이동
        }
    }
};
</script>
<style scoped>
.order-complete-container {
    text-align: center;
    margin: 50px auto;
    max-width: 600px;
    font-family: Arial, sans-serif;
}

h1 {
    font-size: 24px;
}

p {
    margin: 10px 0;
}

.btns {
    background-color: #999;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 20px;
    font-size: 16px;
}
</style>
