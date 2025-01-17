<template>
    <div class="container">
        <TopButton title="상세페이지" />
        <div class="itemBox">
            <div class="itemimg">
                <img :src="product.image" alt="상품이미지" />
            </div>
            <div class="itemText">
                <p class="item_tag">#000 #000 #000</p>
                <p class="item_score"><img src="@/assets/img/leaf.svg" alt="score" /> 4.3점</p>
                <p class="item_title">{{ product.title }}</p>
                <p class="item_price">{{ product.price }} 원</p>
                <div class="numBox">
                    <button @click="decreaseQuantity">-</button>
                    <span>{{ quantity }}</span>
                    <button @click="increaseQuantity">+</button>
                </div>
            </div>
        </div>
        <div class="buttons">
            <button @click="addToCart">장바구니 담기</button>
            <button @click="buyNow">바로 구매하기</button>
        </div>
        <div class="item_content">
            <p>{{ product.content }}</p>
        </div>
    </div>
</template>
<script>
import TopButton from '../components/TopButton.vue';
import CategoryItem from '@/assets/js/CategoryItem.js';

export default {
    name: 'ProductPage',
    components: {
        TopButton
    },
    data() {
        return {
            product: {}, // 선택된 상품 데이터를 저장
            quantity: 1 // 선택한 상품 수량
        };
    },
    created() {
        // URL의 id 파라미터로 상품 데이터 조회
        const productId = this.$route.params.id;
        this.product = CategoryItem.find((item) => item.id === parseInt(productId));
        if (!this.product) {
            console.error('상품을 찾을 수 없습니다.');
        }
    },
    methods: {
        // 수량 감소
        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },
        // 수량 증가
        increaseQuantity() {
            this.quantity++;
        },
        // 장바구니로 상품 전달
        addToCart() {
            const productWithQuantity = { ...this.product, quantity: this.quantity };
            const storedCart = localStorage.getItem('cart');
            const cart = storedCart ? JSON.parse(storedCart) : [];

            const existingItem = cart.find((item) => item.id === productWithQuantity.id);
            if (existingItem) {
                existingItem.quantity += productWithQuantity.quantity; // 기존 수량에 추가
            } else {
                cart.push(productWithQuantity); // 새 상품 추가
            }

            localStorage.setItem('cart', JSON.stringify(cart)); // localStorage에 저장
            alert('장바구니에 상품이 추가되었습니다!');
        },
        // 바로 구매하기
        buyNow() {
            const productWithQuantity = { ...this.product, quantity: this.quantity };
            this.$router.push({
                name: 'Checkout',
                query: { cart: JSON.stringify([productWithQuantity]) } // 바로 구매는 단일 상품
            });
        }
    }
};
</script>
<style scoped>
.itemBox {
    width: 100%;
    margin-top: 20px;
}
.itemBox .itemimg {
    width: 100%;
    height: 350px;
}
.itemBox .itemimg img {
    width: 100%;
    height: 350px;
}
.itemBox .itemText {
    width: 90%;
    margin: 0 auto;
}
.itemBox .itemText p {
    text-align: left;
    margin: 0;
    font-size: 1em;
    line-height: 27px;
}

.itemBox .itemText img {
    margin-right: 5px;
    filter: invert(10%) sepia(89%) saturate(6058%) hue-rotate(83deg) brightness(108%) contrast(86%);
}

.itemBox .itemText .item_score {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.itemBox .itemText .item_title {
    font-size: 1.1em;
    letter-spacing: -0.5px;
    font-weight: 600;
}
.itemBox .itemText .item_price {
    margin-top: 22px;
    font-size: 1.3em;
    display: block;
    float: left;
    margin-right: 10px;
}

.numBox {
    margin-top: 20px;
}

.numBox button {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid #ccc;
    background: none;
    margin: 0 7px;
    font-size: 1.2rem;
    text-align: center;
    line-height: 0px;
}

.numBox span {
    font-size: 1.3rem;
}

.numBox button:hover {
    background: #ccc;
}

.buttons {
    text-align: center;
    margin-top: 30px;
    margin-bottom: 20px;
}

.buttons button {
    border: none;
    border-radius: 20px;
    background-color: #acacac;
    padding: 7px 15px;
    margin: 5px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
}
.buttons button:hover {
    background-color: #8a8a8a;
}
.item_content {
    margin: 10px;
    padding-top: 20px;
    border-top: 1px solid #999;
    border-bottom: 1px solid #999;
}
</style>
