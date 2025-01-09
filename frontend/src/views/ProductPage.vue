<template>
    <div class="container">
        <TopButton title="상세페이지" />
        <div class="itembox">
            <div class="itemimg">
                <img :src="product.image" alt="상품이미지" />
            </div>
            <div class="itemtext">
                <p>#000#000#000</p>
                <p>4.7점</p>
                <p>{{ product.title }}</p>
                <p>{{ product.price }} 원</p>
            </div>
        </div>
        <div class="buttons">
            <button @click="addToCart">장바구니</button>
            <button @click="link2">바로구매</button>
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
            product: {} // 선택된 상품 데이터를 저장
        };
    },
    created() {
        const productId = this.$route.params.id;
        this.product = CategoryItem.find((item) => item.id === parseInt(productId));
        if (!this.product) {
            console.error('상품을 찾을 수 없습니다.');
        }
    },
    methods: {
        // 장바구니로 상품 전달
        addToCart() {
            console.log('전달된 상품 데이터:', JSON.stringify(this.product));
            this.$router.push({
                name: 'ShoppingCart',
                query: { product: JSON.stringify(this.product) }
            });
        },
        link2() {
            alert('바로구매 기능은 아직 구현되지 않았습니다.');
        }
    }
};
</script>
<style scoped>
.itembox {
    width: 100%;
}
.itembox .itemimg {
    width: 100%;
    height: 350px;
    background-color: #999;
}
.itembox .itemimg img {
    width: 100%;
    height: 350px;
}
.itembox .itemtext {
    width: 80%;
    margin: 0 auto;
}
.itembox .itemtext p {
    text-align: left;
}

.buttons {
    width: 80%;
    margin: 0 auto;
}
</style>
