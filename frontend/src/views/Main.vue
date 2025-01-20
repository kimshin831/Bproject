<template>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div class="logo">
                <router-link to="/"><img src="../assets/img/logo.png" alt="logo" /></router-link>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <div class="icon">
                <div class="bell">
                    <router-link to="#"><img src="../assets/img/bell.svg" class="rounded" alt="bell" /></router-link>
                </div>
                <div class="cart">
                    <router-link to="ShoppingCart"
                        ><img src="../assets/img/cart.svg" class="rounded" alt="cart"
                    /></router-link>
                </div>
            </div>
        </div>
    </nav>

    <!-- 슬라이드 배너 -->
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="@/assets/img/slidebanner1.jpg" class="d-block w-100" alt="slidebanner1" />
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="@/assets/img/slidebanner2.jpg" class="d-block w-100" alt="slidebanner2" />
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="@/assets/img/slidebanner3.jpg" class="d-block w-100" alt="slidebanner3" />
            </div>
        </div>
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleInterval"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleInterval"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="category">
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/serum.png" alt="img" />
                <p>기초케어</p>
            </div>
        </router-link>
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/mask.png" alt="img" />
                <p>마스크팩</p>
            </div>
        </router-link>
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/clean.png" alt="img" />
                <p>클렌징</p>
            </div>
        </router-link>
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/soap.png" alt="img" />
                <p>천연비누</p>
            </div>
        </router-link>
    </div>
    <div class="category">
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/cosmetics.png" alt="img" />
                <p>비건제품</p>
            </div>
        </router-link>
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/tube.png" alt="img" />
                <p>모공제품</p>
            </div>
        </router-link>
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/cleane.png" alt="img" />
                <p>미백/화이트닝</p>
            </div>
        </router-link>
        <router-link to="#">
            <div class="item">
                <img src="../assets/img/medicine.png" alt="img" />
                <p>피부영양제</p>
            </div>
        </router-link>
    </div>
    <router-link to="#">
        <div class="skintest">
            <img src="../assets/img/skintest.png" alt="img" />
        </div>
    </router-link>

    <!-- 이벤트 -->
    <div class="image-slider" @mouseover="stopAutoSlide" @mouseleave="startAutoSlide">
        <div class="slides" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
            <div v-for="(slide, index) in slides" :key="index" class="slide" @click="eventImg">
                <img :src="slide" alt="Slide image" />
            </div>
        </div>
        <button @click="prevSlide" class="button2"><</button>
        <button @click="nextSlide" class="button2">></button>
    </div>
    <div class="margin"></div>
</template>

<script>
export default {
    data() {
        return {
            slides: [
                require('@/assets/img/event11.jpg'),
                require('@/assets/img/event22.jpg'),
                require('@/assets/img/event33.jpg')
            ],
            currentSlide: 0,
            intervalId: null // 자동 전환을 위한 interval ID
        };
    },
    methods: {
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        },
        startAutoSlide() {
            this.intervalId = setInterval(() => {
                this.nextSlide();
            }, 4000);
        },
        stopAutoSlide() {
            clearInterval(this.intervalId);
            this.intervalId = null;
        },
        eventImg() {
            this.$router.push('/event');
        }
    },
    mounted() {
        this.startAutoSlide(); // 컴포넌트가 마운트될 때 자동 전환 시작
    },
    beforeDestroy() {
        this.stopAutoSlide(); // 컴포넌트가 파괴되기 전 자동 전환 멈춤
    }
};
</script>

<style scoped>
a {
    color: none;
    text-decoration: none;
}

body {
    overflow-x: hidden;
    position: relative;
    top: 30px;
}

.navbar.bg-body-tertiary {
    background: #fff;
    padding: 0;
    margin: 0.5rem 0 0.5rem 0.5rem;
}

.container-fluid {
    height: 50px;
    background: #fff;
}

.logo {
    margin-right: 12px;
}

.logo img {
    height: 25px;
}

.d-flex {
    width: 170px;
    height: 35px;
    position: relative;
    border: 1px solid black;
    border-radius: 5px;
    background: #fff;
}

.form-control.me-2 {
    width: 160px;
    height: auto;
    border: none;
    background: none;
}

.btn.btn-outline-success {
    position: absolute;
    top: 18px;
    left: 140px;
    width: 25px;
    height: 25px;
    background: url(@/assets/img/search.svg) no-repeat;
    text-indent: -9999px;
    border: none;
}

.btn.btn-outline-success:hover {
    background: #fff;
    background: url(@/assets/img/search.svg) no-repeat;
}

.icon {
    float: right;
}
.icon > div {
    float: left;
}

.carousel-item {
    width: 100%;
    height: 60vh;
}

.carousel-item > img {
    width: 100%;
    height: 80vh;
    object-fit: cover;
}

.rounded {
    width: auto;
    height: 20px;
    float: left;
    padding-right: 7px;
}

.category {
    height: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 7px 15px 0px 15px;
}

.category:nth-child(odd) {
    margin-top: 18px;
}

.category .item {
    width: 74px;
    height: 74px;
    text-align: center;
}

.category .item:hover {
    transform: scale(1.13);
}

.category .item img {
    width: auto;
    height: 33px;
    text-align: center;
}

.category .item > p {
    margin-top: 7px;
    font-size: 11px;
    text-align: center;
    color: black;
    text-decoration: none;
}

.skintest {
    width: 300px;
    height: 115px;
    margin: 0 auto;
    margin-top: 15px;
    margin-bottom: 30px;
}

.skintest img {
    width: 100%;
    height: 115px;
    margin: 0;
    object-fit: cover;
    object-position: top;
}

/* 이벤트 배너 */
.image-slider {
    position: relative;
    overflow: hidden;
    width: 100%; /* 너비 설정 */
    height: 170px; /* 높이 설정 */
}
.slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
    height: 170px;
}
.slide {
    min-width: 100%;
    height: 100%;
    cursor: pointer;
}
.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* 이미지 비율 유지 */
}

button {
    position: absolute;
    top: 50%;
    width: 30px;
    height: 30px;
    transform: translateY(-50%);
    border: none;
    cursor: pointer;
    z-index: 1;
}

.button2 {
    position: absolute;
    top: 50%;
    width: 30px;
    height: 30px;
    transform: translateY(-50%);
    color: #555;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1;
}

.button2:hover {
    background: #888;
    color: white;
}
button:nth-child(2) {
    left: 10px;
}
button:nth-child(3) {
    right: 10px;
}
.margin {
    height: 63px;
}
</style>
