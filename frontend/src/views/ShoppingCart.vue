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
        <div class="contents">
            <div class="contentBox">
                <div class="itemName">
                    <input type="checkbox" value="" id="name" checked />
                    <label for="name"> 스킨소스 아데노신 10000앰플 30ml </label>
                </div>
                <div class="itemBox">
                    <div class="itemImg">
                        <img src="" alt="" />
                    </div>
                    <div class="itemOptions">
                        <p>
                            <span>{{ price }}원</span>
                        </p>
                        <p>1일이내 발송예정</p>
                        <div class="numBox">
                            <p>수량변경</p>
                            <button @click="decrease">-</button>
                            <span>{{ num }}</span>
                            <button @click="increase">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="buyBox">
            <div class="buyContent">
                <p>총 {{ num }} 개</p>
                <p>{{ price * num }}<span>원</span></p>
            </div>
            <div class="buyButton">
                <button>구매하기</button>
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
    data() {
        return {
            num: 1,
            price: 22000
        };
    },
    methods: {
        decrease() {
            if (this.num > 1) {
                this.num -= 1;
            }
        },
        increase() {
            this.num += 1;
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

.itemOptions .numBox {
    width: auto;
    margin: 0 auto;
    margin-top: 19px;
    float: left;
    line-height: 30px;
    background: #ececec;
    padding: 5px;
    border-radius: 3px;
}

.itemOptions .numBox p {
    margin-right: 7px;
}

.numBox button {
    width: 20px;
    font-size: 1.2rem;
    margin: 3px 0;
    border: none;
    background: none;
}

.itemOptions span {
    font-weight: bold;
    font-size: 1.2rem;
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
</style>
