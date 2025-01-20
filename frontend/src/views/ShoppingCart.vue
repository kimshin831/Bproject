<template>
    <div class="container">
        <TopButton title="장바구니" />
        <div class="check_box">
            <div class="check">
                <input type="checkbox" id="check" v-model="allSelected" @change="toggleAllSelected" />
                <label for="check"> 전체선택 </label>
            </div>
            <div class="checkdelete">
                <button @click="removeSelected"><span>선택상품삭제</span></button>
                <button @click="clearCart"><span>전체상품삭제</span></button>
            </div>
        </div>
        <div class="contents" v-if="cart.length > 0">
            <div class="contentBox" v-for="item in cart" :key="item.id">
                <div class="itemName">
                    <input type="checkbox" v-model="item.selected" @change="updateAllSelected" />
                    <label>{{ item.title }}</label>
                </div>
                <div class="itemBox">
                    <div class="itemImg">
                        <img :src="item.image" alt="상품 이미지" />
                    </div>
                    <div class="itemOptions">
                        <p>{{ item.price.toLocaleString() }} 원</p>
                        <p>1일 이내 발송 예정</p>
                        <div class="numBox">
                            <p>수량</p>
                            <div class="item_qu">
                                <button @click="updateQuantity(item, item.quantity - 1)">-</button>
                                <span>{{ item.quantity }}</span>
                                <button @click="updateQuantity(item, item.quantity + 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="v-else">
            <p>장바구니가 비어 있습니다.</p>
        </div>
        <div class="bottomBox"></div>
        <div class="buyBox" v-if="cart.length > 0">
            <div class="buyContent">
                <p>총 {{ totalQuantity }} 개</p>
                <p>{{ totalPrice.toLocaleString() }} <span>원</span></p>
            </div>
            <div class="buyButton">
                <button @click="goToCheckout">구매하기</button>
            </div>
        </div>
    </div>
    <div class="margin"></div>
</template>

<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'ShoppingCart',
    components: {
        TopButton
    },
    data() {
        return {
            cart: [],
            allSelected: false // 전체 선택 상태 // 장바구니 데이터
        };
    },
    created() {
        // localStorage에서 장바구니 데이터 로드
        const storedCart = localStorage.getItem('cart');
        this.cart = storedCart ? JSON.parse(storedCart) : [];

        // 전체선택 상태 초기화
        this.updateAllSelected();
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
        saveCart() {
            // localStorage에 장바구니 데이터 저장
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },
        addToCart(product) {
            // 장바구니에 상품 추가
            const existingItem = this.cart.find((item) => item.id === product.id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1, selected: false });
            }
            this.saveCart(); // 업데이트 후 저장
        },
        updateQuantity(item, newQuantity) {
            // 수량 업데이트
            if (newQuantity < 1) return; // 최소 수량 제한
            item.quantity = newQuantity;
            this.saveCart(); // 업데이트 후 저장
        },
        removeSelected() {
            // 선택된 상품 삭제
            this.cart = this.cart.filter((item) => !item.selected);
            this.saveCart(); // 업데이트 후 저장
            this.updateAllSelected(); // 전체선택 상태 업데이트
        },
        clearCart() {
            // 장바구니 비우기
            this.cart = [];
            this.saveCart();
            this.updateAllSelected(); // 전체선택 상태 초기화
        },
        goToCheckout() {
            // 체크아웃 페이지로 이동
            this.$router.push({
                name: 'Checkout',
                query: { cart: JSON.stringify(this.cart) }
            });
        },
        toggleAllSelected() {
            // 전체선택 상태를 모든 상품에 반영
            this.cart.forEach((item) => {
                item.selected = this.allSelected;
            });
            this.saveCart(); // 업데이트 후 저장
        },
        updateAllSelected() {
            // 개별 선택 상태에 따라 전체선택 상태 업데이트
            this.allSelected = this.cart.every((item) => item.selected);
        }
    },
    watch: {
        cart: {
            handler() {
                localStorage.setItem('cart', JSON.stringify(this.cart)); // 장바구니 데이터 변경 시 전체선택 상태 업데이트
            },
            deep: true
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
    font-weight: bold;
    font-size: 1rem;
    letter-spacing: -1px;
    margin-bottom: 20px;
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
}

.itemOptions p:first-child {
    font-weight: bold;
    font-size: 1.2rem;
}

.itemOptions .numBox {
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 140px;
    margin-top: 10px;
    padding: 3px 2px;
    background: #ececec;
    text-align: left;
    border-radius: 3px;
}

.itemOptions .numBox p {
    font-size: 0.93rem;
}

.numBox button {
    width: auto;
    font-size: 1.1rem;
    margin: 3px 0;
    border: none;
    background: none;
}

.item_qu {
    float: right;
}
.item_qu button {
    color: black;
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

.margin {
    height: 140px;
}
</style>
