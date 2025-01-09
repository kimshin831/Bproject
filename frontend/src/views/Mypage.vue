<template>
    <TopButton title="마이페이지" />
    <div class="container">
        <div class="profile">
            <img src="@/assets/img/profile.png" alt="?" />
            <div class="title">야생동물을 구해주세요.</div>
            <a class="login" @click="Login">로그인 &gt;</a>
        </div>
        <div class="stats">
            <div>
                <a class="link point">
                    <strong>0P</strong>
                    포인트
                </a>
            </div>
            <div>
                <a class="link coupon">
                    <strong>0장</strong>
                    쿠폰
                </a>
            </div>
            <div>
                <a class="link order">
                    <strong>0</strong>
                    주문내역
                </a>
            </div>
            <div>
                <a class="link delivery">
                    <strong>0</strong>
                    배송
                </a>
            </div>
            <div>
                <a class="link evaluation">
                    <strong>0</strong>
                    나의 평가
                </a>
            </div>
            <div>
                <a class="link inquiry">
                    <strong>0</strong>
                    문의
                </a>
            </div>
        </div>
        <div class="section">
            <ul class="event">
                이벤트
                <li>이벤트 신청 / 당첨내역</li>
                <li>이벤트 배송지 수정</li>
            </ul>
            <ul class="service">
                고객센터
                <li>제품등록 요청</li>
                <li>요청등록 제품</li>
                <li>Q & A</li>
                <li>1:1 문의</li>
                <li>설정</li>
            </ul>
        </div>
    </div>
</template>
<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'Mypage',
    components: {
        TopButton
    },
    methods: {
        Login() {
            this.$router.push('/login');
        }
    }
};
</script>
<style scoped>
.link {
    cursor: pointer;
    text-decoration: none;
    color: #000;
}
.container {
    margin-top: 25px;
    text-align: center;
}

.profile {
    height: 100px;
    margin-bottom: 20px;
    line-height: 17px;
}

.profile img {
    width: 85px;
    height: 85px;
    float: left;
    object-fit: scale-down;
    border-radius: 50%;
    border: 1px solid #000;
    margin-right: 10px;
}

.profile .title {
    float: left;
    margin: 10px 0;
    font-size: 22px;
    font-weight: bold;
    color: #555;
    line-height: 30px;
}

.login {
    float: left;
    font-size: 1.1rem;
    text-decoration: none;
    color: #333;
    font-weight: bold;
    cursor: pointer;
}

.stats {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin: 30px 0;
}

.stats div {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    font-size: 14px;
    background: #f5f5f5;
}

.stats div strong {
    display: block;
    font-size: 20px;
    margin-bottom: 5px;
}
</style>
