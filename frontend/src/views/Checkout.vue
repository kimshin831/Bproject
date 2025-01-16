<template>
    <div class="container">
        <TopButton title="구매하기" />
        <div class="checkout-container">
            <!-- 배송지 정보 -->
            <div class="section">
                <h2 class="Shipping">배송지 정보 <span>필수</span></h2>
                <button class="address">신규 배송지 등록</button>
                <h2 v-if="!deliveryRequest" class="Shipping">배송시 요청사항 <span>필수</span></h2>
                <select v-model="deliveryRequest" class="dropdown">
                    <option disabled value="">요청사항 선택</option>
                    <option>문 앞에 놓아주세요</option>
                    <option>경비실에 맡겨주세요</option>
                    <option>직접 수령하겠습니다</option>
                </select>
            </div>

            <!-- 주문 상품 정보 -->
            <div class="section s1" v-if="cart.length > 0">
                <h2>주문 상품 정보</h2>
                <div class="product-info" v-for="item in cart" :key="item.id">
                    <div class="product-image">
                        <img :src="item.image" alt="상품 이미지" />
                    </div>
                    <div class="product-details">
                        <p>NEDE</p>
                        <p class="item_title">{{ item.title }}</p>
                        <p>수량 : {{ item.quantity }}개</p>
                        <p>
                            <strong>{{ item.price.toLocaleString() }}원</strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- 포인트 -->
            <div class="section s2">
                <h2>포인트</h2>
                <p class="small">결제 금액의 50%까지 포인트 사용이 가능합니다.</p>
                <div class="points">
                    <input
                        type="number"
                        v-model.number="pointsUsed"
                        placeholder="0P"
                        class="input"
                        @input="validatePoints"
                    />
                    <button @click="useMaxPoints" class="btns">최대사용</button>
                    <button @click="resetPoints" class="btns">초기화</button>
                </div>
            </div>

            <!-- 결제 금액 확인 -->
            <div class="section s3">
                <h2>결제 금액 확인</h2>
                <p>
                    총 상품 금액: <strong>{{ totalPrice.toLocaleString() }}원</strong>
                </p>
                <p>
                    포인트 사용: <strong>- {{ pointsUsed.toLocaleString() }}원</strong>
                </p>
                <p>
                    배송비: <strong>{{ shippingFee.toLocaleString() }}원</strong>
                </p>
                <p>
                    <strong>총 결제 금액: {{ finalPrice.toLocaleString() }}원</strong>
                </p>
            </div>

            <!-- 결제 수단 -->
            <div class="section s4">
                <h2>결제 수단</h2>
                <div class="payment-methods">
                    <button class="btns bt">신용/체크카드</button>
                    <button class="btns bt">실시간 계좌이체</button>
                    <button class="btns bt">네이버 페이</button>
                    <button class="btns bt">카카오 페이</button>
                </div>
            </div>

            <!-- 동의 항목 -->
            <section class="section s5">
                <div class="checkbox-group">
                    <div>
                        <input type="checkbox" v-model="agreeTerms" id="agree-terms" />
                        <label for="agree-terms">전체 동의</label>
                    </div>
                    <div>
                        <input type="checkbox" v-model="agreeOrderCheck" id="agree-order-check" />
                        <label for="agree-order-check">주문내용 확인 및 결제 동의 <span>필수</span></label>
                    </div>
                    <div>
                        <input type="checkbox" v-model="agreePrivacy" id="agree-privacy" />
                        <label for="agree-privacy">개인정보 제공 제3자 제공 동의 <span>필수</span></label>
                    </div>
                </div>
            </section>

            <!-- 결제하기 버튼 -->
            <div class="button-container">
                <button class="pay-button" @click="confirmOrder">결제하기</button>
            </div>
        </div>
        <div class="margin"></div>
    </div>
</template>

<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'Checkout',
    components: {
        TopButton
    },
    data() {
        return {
            deliveryRequest: '', // 배송 요청사항 선택 값
            pointsUsed: 0, // 사용된 포인트
            shippingFee: 0, // 배송비
            cart: [], // 장바구니 데이터
            agreeTerms: false, // 전체 동의
            agreeOrderCheck: false, // 주문내용 확인 동의
            agreePrivacy: false // 개인정보 제공 동의
        };
    },
    created() {
        const cartQuery = this.$route.query.cart;
        if (cartQuery) {
            this.cart = JSON.parse(cartQuery); // JSON 문자열을 객체로 변환
        }
    },
    computed: {
        totalPrice() {
            return this.cart.reduce((total, item) => total + item.price * item.quantity, 0);
        },
        finalPrice() {
            return Math.max(this.totalPrice - this.pointsUsed + this.shippingFee, 0);
        }
    },
    watch: {
        // 전체 동의 상태 변경 시 개별 항목 동기화
        agreeTerms(newValue) {
            this.agreeOrderCheck = newValue;
            this.agreePrivacy = newValue;
        },
        // 개별 항목 변경 시 전체 동의 상태 업데이트
        agreeOrderCheck: 'updateAgreeTerms',
        agreePrivacy: 'updateAgreeTerms'
    },
    methods: {
        updateAgreeTerms() {
            this.agreeTerms = this.agreeOrderCheck && this.agreePrivacy;
        },
        useMaxPoints() {
            this.pointsUsed = Math.min(this.totalPrice * 0.5, this.totalPrice);
        },
        resetPoints() {
            this.pointsUsed = 0;
        },
        validatePoints() {
            if (this.pointsUsed < 0) this.pointsUsed = 0;
            if (this.pointsUsed > this.totalPrice * 0.5) {
                this.pointsUsed = Math.floor(this.totalPrice * 0.5);
            }
        },
        confirmOrder() {
            if (!this.deliveryRequest) {
                alert('배송 요청사항을 선택해주세요.');
                return;
            }
            if (!this.agreeOrderCheck || !this.agreePrivacy) {
                alert('필수 동의 항목을 모두 체크해주세요.');
                return;
            }
            alert('결제가 완료되었습니다! 감사합니다.');
            this.$router.push({
                name: 'OrderComplete',
                query: { total: this.finalPrice }
            });
        }
    }
};
</script>

<style scoped>
.checkout-container {
    margin: 15px;
}

.section {
    margin-top: 30px;
}

.section.s1 {
    border-top: 1.5px solid #6f6f6f;
    border-bottom: 1.5px solid #6f6f6f;
    padding: 20px 0;
}

.section.s2,
.s3 {
    border-bottom: 1.5px solid #6f6f6f;
    padding-bottom: 20px;
}

.s4 {
    border-bottom: 1.5px solid #6f6f6f;
    padding-bottom: 30px;
}

.section h2 {
    font-size: 16px;
    font-weight: bold;
    letter-spacing: -0.5px;
    margin-bottom: 7px;
}

.small {
    font-size: 14px;
    margin-bottom: 3px;
}

.btns {
    display: inline-block;
    font-size: 13px;
    padding: 5px;
    margin-right: 5px;
    color: #6f6f6f;
    border: 0.7px solid #6f6f6f;
    background: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 7px;
    font-weight: bold;
}

.btns:hover {
    background: #555;
    color: #fff;
}

.btns.bt {
    width: 47%;
    padding: 10px 0;
    font-weight: bold;
}

.Shipping > span {
    font-size: 0.75rem;
    color: red;
}

.address {
    width: 100%;
    padding: 7px;
    margin-top: 3px;
    margin-bottom: 30px;
    background: none;
    border-radius: 5px;
    border: 1px solid #6f6f6f;
    font: 14px;
    color: #6f6f6f;
    font-weight: bold;
}
.dropdown {
    width: 100%;
    padding: 7px;
    border-radius: 5px;
    border: 1px solid #6f6f6f;
    font: 14px;
    color: #6f6f6f;
    font-weight: bold;
}

.product-info {
    display: flex;
    align-items: center;
}

.item_title {
    font-weight: bold;
    font-size: 15px;
}

.product-info > .product-details > p > strong {
    font-size: 1.15rem;
}

.product-image {
    width: 170px;
    height: 170px;
    margin-right: 10px;
}
.product-image img {
    width: 170px;
    height: 170px;
    object-fit: cover;
    margin-right: 10px;
}

.product-details p {
    margin: 5px 0;
}

.points {
    display: flex;
    align-items: center;
}

.input {
    flex: 1;
    padding: 3px 0 3px 7px;
    margin-top: 7px;
    margin-right: 10px;
    border: 1px solid #6f6f6f;
    border-radius: 5px;
}

.checkbox {
    margin-top: 10px;
}

.checkbox > input {
    margin-right: 5px;
}

.checkbox > label {
    font-size: 0.9rem;
}

.checkbox-group > div > input {
    margin-right: 5px;
}

.checkbox-group > div > label {
    font-size: 0.9rem;
}
.checkbox-group > div > label span {
    font-size: 0.75rem;
    color: red;
}

.payment-methods .btn {
    margin: 5px;
    width: calc(50% - 10px);
}
.button-container {
    padding-bottom: 50px;
}
.pay-button {
    width: 100%;
    padding: 8px;
    margin-top: 15px;
    border: none;
    border-radius: 5px;
    background: #999;
    color: white;
    font-weight: bold;
}

.pay-button:hover {
    background: #555;
}

.margin {
    height: 25px;
}
</style>
