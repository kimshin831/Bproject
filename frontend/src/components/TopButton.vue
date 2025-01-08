<template>
    <div>
        <div class="header">
            <div class="topBox">
                <div class="col1">
                    <button @click="goBack">
                        <img src="../assets/img/chevron-left-solid.svg" alt="뒤로가기" width="20" height="20" />
                    </button>
                </div>
                <div class="col2">{{ title }}</div>
                <div class="col3">
                    <button @click="link1">
                        <img src="../assets/img/magnifying-glass-solid .svg" alt="검색" width="20" height="20" />
                    </button>
                    <button @click="link2">
                        <img src="../assets/img/bell-regular.svg" alt="알림" width="20" height="20" />
                    </button>
                    <button @click="ShoppingCart">
                        <img src="@/assets/img/cart.svg" alt="장바구니" width="auto" height="20" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'TopButton',
    props: {
        title: String
    },
    methods: {
        goBack() {
            this.$router.go(-1); // 뒤로가기
        },
        link1() {
            window.location.href = '/';
        },
        link2() {
            window.location.href = '/';
        },
        ShoppingCart() {
            this.$router.push('/shoppingcart');
        }
    }
};
</script>
<style scoped>
.topBox {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    gap: 10px;
    text-align: center;
    margin-top: 25px;
}

button {
    border: 0px;
    background: transparent;
    padding: 0;
}

.col1 {
    flex: 1;
    text-align: left;
    margin-left: 10px;
}
.col2 {
    font-size: 1.2em;
    font-weight: 700;
    color: black;
    flex: 2;
}
.col3 {
    display: flex;
    flex: 1;
    justify-content: space-between;
    align-items: center;
    margin-right: 10px;
}
</style>
