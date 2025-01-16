<template>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div class="logo">
                <router-link to="/main"><img src="../assets/img/logo.png" alt="logo" /></router-link>
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
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" style="margin-top: 30px">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../assets/img/event11.jpg" class="d-block w-100" alt="event1" />
            </div>
            <div class="carousel-item">
                <img src="../assets/img/event22.jpg" class="d-block w-100" alt="event2" />
            </div>
            <div class="carousel-item">
                <img src="../assets/img/event33.jpg" class="d-block w-100" alt="event3" />
            </div>
        </div>
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="margin"></div>
</template>

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
    margin: 0.5rem 0;
}

.container-fluid {
    position: relative;
    padding: 0 10px;
    background: #fff;
}

.logo {
    margin-right: 12px;
}

.d-flex {
    width: 206px;
    height: 35px;
    position: relative;
    border: 1px solid black;
    border-radius: 5px;
    background: #fff;
}

.form-control.me-2 {
    width: 206px;
    height: auto;
    border: none;
    background: none;
}

.btn.btn-outline-success {
    position: absolute;
    top: 7px;
    right: 0;
    width: 25px;
    height: 25px;
    background: url(@/assets/img/search.svg) no-repeat;
    text-indent: -9999px;
    z-index: 50;
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

.carousel-item > img {
    width: 100%;
    height: 390px;
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
}

.skintest img {
    width: 100%;
    height: 115px;
    margin: 0;
    object-fit: cover;
    object-position: top;
}

.carousel-item {
    width: 100%;
    height: auto;
}

#carouselExampleAutoplaying:nth-child(odd) .carousel-inner .carousel-item > img {
    width: 100%;
    height: 115px;
    object-fit: cover;
}

.margin {
    height: 63px;
}
</style>
