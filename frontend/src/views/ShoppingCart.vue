<template>
    <div class="container">
        <TopButton title="장바구니" />
        <div class="check_box">
            <div class="check">
                <input type="checkbox" value="" id="check" checked />
                <label for="check"> 전체선택 </label>
            </div>
            <div class="checkdelete">
                <button><span>선택상품삭제</span></button>
                <button><span>전체상품삭제</span></button>
            </div>
        </div>
        <div class="contents" v-if="cart.length > 0">
            <div class="contentBox" v-for="item in cart" :key="item.id">
                <div class="itemName">
                    <input type="checkbox" value="" id="name" checked />
                    <label for="name"> {{ item.title }} </label>
                </div>
                <div class="itemBox">
                    <div class="itemImg">
                        <img :src="item.image" alt="상품 이미지" />
                    </div>
                    <div class="itemOptions">
                        <p>{{ item.price }} 원</p>
                        <p>1일이내 발송예정</p>
                        <p>옵션</p>
                        <div class="numBox">
                            <p>수량변경</p>
                            <button @click="decrease(item)">-</button>
                            <span>{{ item.quantity }}</span>
                            <button @click="increase(item)">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="v-else">
            <p>장바구니가 비어 있습니다.</p>
        </div>
        <div class="buyBox" v-if="cart.length > 0">
            <div class="buyContent">
                <p>총 {{ totalQuantity }} 개</p>
                <p>{{ totalPrice }} <span>원</span></p>
            </div>
            <div class="buyButton">
                <button @click="goToCheckout">구매하기</button>
            </div>
        </div>
    </div>
</template>
<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'ShoppingCart',
    components: {
        TopButton
    },
    props: ['product'], // 라우터 params로 전달된 데이터를 props로 받음
    data() {
        return {
            cart: [] // 장바구니 데이터
        };
    },
    created() {
        // query로 전달된 데이터를 파싱하여 장바구니에 추가
        console.log('수신된 JSON 데이터:', this.$route.query.product);
        const productQuery = this.$route.query.product;
        if (productQuery) {
            const productData = JSON.parse(productQuery); // JSON 문자열 파싱
            const existingItem = this.cart.find((item) => item.id === productData.id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.cart.push({ ...productData, quantity: 1 });
            }
        }
    },
    computed: {
        // 총 가격 계산
        totalPrice() {
            return this.cart.reduce((total, item) => total + item.price * item.quantity, 0);
        },
        // 총 수량 계산
        totalQuantity() {
            return this.cart.reduce((total, item) => total + item.quantity, 0);
        }
    },
    methods: {
        // 수량 감소
        decrease(item) {
            if (item.quantity > 1) {
                item.quantity--;
            }
        },
        // 수량 증가
        increase(item) {
            item.quantity++;
        },
        goToCheckout() {
            // 체크아웃 페이지로 데이터 전달
            this.$router.push({
                name: 'Checkout',
                query: { cart: JSON.stringify(this.cart) } // JSON 문자열로 변환 후 전달
            });
        }
    }
};
</script>
<style scoped>
/* 상단 체크박스 */
.check_box {
    margin-top: 25px;
    display: flex;
    justify-content: space-between;
    font-size: 12px;
}

.check {
    margin-left: 15px;
}
.check input {
    margin-right: 5px;
}

.checkdelete button {
    border: none;
    background: none;
    margin-right: 10px;
    padding: 0;
}

/* 상품  */
.contents {
    margin: 0 auto;
    width: 95%;
    height: 100vh;
    margin-top: 15px;
    border: 1px solid #999;
    border-radius: 10px 10px 0 0;
}

.itemName {
    letter-spacing: -1px;
}

.itemName input {
    margin-right: 5px;
}

.contents .contentBox {
    margin: 0 auto;
    width: 90%;
    height: 200px;
    margin-top: 25px;
    border-bottom: 1px solid #999;
}

.contents .contentBox .itemBox {
    width: 100%;
    margin: 15px 0;
}
.contents .contentBox .itemBox .itemImg {
    width: 137px;
    height: 137px;
    background-color: #999;
    margin-right: 20px;
    float: left;
}
.contents .contentBox .itemBox .itemImg img {
    width: 137px;
    height: 137px;
}
.itemOptions {
    text-align: left;
    line-height: 1.3rem;
}
.itemOptions p {
    margin: 5px;
    margin-bottom: 7px;
    text-align: left;
    float: left;
}

.itemOptions p:first-child {
    font-weight: bold;
    font-size: 1.2rem;
}

.itemOptions .numBox {
    width: 143px;
    margin-top: 5px;
    float: left;
    line-height: 20px;
    background: #ececec;
    text-align: center;
    padding: 3px 0;
    border-radius: 3px;
}

.itemOptions .numBox p {
    font-size: 0.95rem;
    margin-left: 13px;
}

.numBox button {
    width: auto;
    font-size: 1.1rem;
    margin: 3px 0;
    border: none;
    background: none;
}

.itemOptions span {
    font-weight: bold;
    font-size: 1.1rem;
}

/* 하단 구매하기 */
.buyBox {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #ccc;
    height: 200px;
    border-radius: 45px 45px 0 0;
}
.buyBox .buyContent {
    width: 80%;
    display: flex;
    justify-content: space-between;
    margin: 0 auto;
    margin-top: 30px;
}

.buyBox .buyContent p {
    float: left;
    font-size: 1.2rem;
    font-weight: bold;
    margin: 0 7px;
}

.buyButton {
    width: 90%;
    display: flex;
    justify-content: center;
    margin: 0 auto;
    margin-top: 15px;
}

.buyButton button {
    height: 40px;
    width: 90%;
    display: flex;
    justify-content: center;
    align-items: center;
    border: none;
    border-radius: 5px;
    font-weight: bold;
}
.v-else {
    height: 100vh;
    text-align: center;
    line-height: 75vh;
}

.v-else > p {
    margin: 0 auto;
    font-size: 1.25rem;
    letter-spacing: -0.3px;
    font-weight: bold;
}
</style>
