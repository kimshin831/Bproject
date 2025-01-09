<template>
    <div class="footerWrap">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <button
                    class="btn btn-primary"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasWithBothOptions"
                    aria-controls="offcanvasWithBothOptions"
                >
                    <img src="../assets/img/bars-solid.png" alt="logo" width="19" height="auto" />
                    <p>카테고리</p>
                </button>

                <div
                    class="offcanvas offcanvas-start"
                    data-bs-scroll="true"
                    tabindex="-1"
                    id="offcanvasWithBothOptions"
                    aria-labelledby="offcanvasWithBothOptionsLabel"
                >
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    <div class="offcanvas-header">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne"
                                        aria-expanded="true"
                                        aria-controls="collapseOne"
                                    >
                                        BEST ITEM
                                    </button>
                                </h2>
                                <div
                                    id="collapseOne"
                                    class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <a class="nav-link">BEST ITEM</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo"
                                        aria-expanded="false"
                                        aria-controls="collapseTwo"
                                    >
                                        카테고리별
                                    </button>
                                </h2>
                                <div
                                    id="collapseTwo"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <a @click="Category" class="nav-link">비누/ 클랜징</a>
                                        <a class="nav-link">마스크/ 팩/ 필링</a>
                                        <a class="nav-link">스킨/토너/미스트</a>
                                        <a class="nav-link">앰플/에센스/세럼</a>
                                        <a class="nav-link">수분젤/에센셜</a>
                                        <a class="nav-link">로션/크림</a>
                                        <a class="nav-link">썬케어</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree"
                                        aria-expanded="false"
                                        aria-controls="collapseThree"
                                    >
                                        기능별
                                    </button>
                                </h2>
                                <div
                                    id="collapseThree"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <a class="nav-link">시카</a>
                                        <a class="nav-link">미백/ 화이트닝</a>
                                        <a class="nav-link">장벽케어</a>
                                        <a class="nav-link">안티에이징</a>
                                        <a class="nav-link">각질관리</a>
                                        <a class="nav-link">남성용</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour"
                                        aria-expanded="false"
                                        aria-controls="collapseFour"
                                    >
                                        성분별
                                    </button>
                                </h2>
                                <div
                                    id="collapseFour"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <a class="nav-link" @click="Ingredient">어성초</a>
                                        <a class="nav-link">콜라겐</a>
                                        <a class="nav-link">히알루론산</a>
                                        <a class="nav-link">판테놀</a>
                                        <a class="nav-link">레티놀</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive"
                                        aria-expanded="false"
                                        aria-controls="collapseFive"
                                    >
                                        고민별
                                    </button>
                                </h2>
                                <div
                                    id="collapseFive"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <a class="nav-link">트러블</a>
                                        <a class="nav-link">주름</a>
                                        <a class="nav-link">모공/피지</a>
                                        <a class="nav-link">수부지</a>
                                        <a class="nav-link">탈모케어</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix"
                                        aria-expanded="false"
                                        aria-controls="collapseSix"
                                    >
                                        Community
                                    </button>
                                </h2>
                                <div
                                    id="collapseSix"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <a class="nav-link">Reviw</a>
                                        <a class="nav-link">EVENT</a>
                                        <a class="nav-link">문의하기</a>
                                        <a class="nav-link">안티에이징</a>
                                        <a class="nav-link">FAQ</a>
                                        <a class="nav-link">공지사항</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link">
                    <div class="nav_icon" @click="Qna">
                        <img src="../assets/img/qna.svg" alt="qna" />
                        <p>Q&A</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link">
                    <div class="nav_icon" @click="Main">
                        <img src="../assets/img/NEDE_logo.png" alt="logo" class="nav_logo" />
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link">
                    <div class="nav_icon">
                        <img src="../assets/img/real.svg" alt="review" />
                        <p>리얼리뷰</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" @click="Mypage">
                    <div class="nav_icon">
                        <img src="../assets/img/user.svg" alt="qna" />
                        <p>마이페이지</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    name: 'footerFix',
    methods: {
        Category() {
            this.$router.replace('/category').then(() => {
                window.location.reload(); // 새로고침 강제 수행
            });
        },
        Mypage() {
            this.$router.push('/mypage');
        },
        Main() {
            this.$router.push('/');
        },
        Qna() {
            this.$router.push('/qna');
        },
        Ingredient() {
            this.$router.push('/ingredient');
        }
    }
};
</script>

<style scoped>
a {
    cursor: pointer;
}
.footerWrap {
    width: 100%;
    height: 63px;
    line-height: 63px;
    position: fixed;
    bottom: 0;
    background-color: #fff;
    z-index: 1000;
}
.nav.justify-content-center {
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
}

.nav-item {
    width: 20%;
    height: 63px;
    float: left;
    text-align: center;
    font-size: 9.8pt;
}

.nav-link {
    padding: 5px;
    color: #000;
}

.nav-link:hover {
    color: #000;
}

.btn-primary {
    background-color: transparent;
    border: 0px solid;
    color: #000;
    text-align: center;
    font-size: 9pt;
}

.btn-primary:hover {
    background: #fff;
    color: #000;
}

.btn-primary > p {
    margin: 0;
    padding-top: 5px;
}

.nav_icon {
    width: 78.5px;
    height: 63px;
    line-height: 7px;
}

.nav_icon > img {
    margin-top: 6px;
    width: auto;
    height: 20px;
}

.nav_icon > img.nav_logo {
    margin-top: 6px;
    width: auto;
    height: 37px;
}

.nav_icon > p {
    text-align: center;
    font-size: 9pt;
    padding-top: 10px;
    margin: 0;
}
.btn-close {
    position: absolute;
    top: 10px;
    right: 10px;
}

#offcanvasWithBothOptions {
    width: 70%;
}

.accordion {
    width: 85%;
    position: absolute;
    top: 50px;
}

.accordion-item {
    border: 0px;
}

.accordion-button {
    font-weight: 700;
}

.accordion-button::after {
    font-size: 13px;
    content: '▼';
    background: transparent;
}

.accordion-button:not(.collapsed) {
    background: #a68151;
    color: #fff;
    font-weight: 700;
}

.accordion-button:not(.collapsed)::after {
    margin-right: 8px;
    font-size: 13px;
    content: '▼';
    background: transparent;
}

.accordion-body {
    width: 95%;
    margin: 0 auto;
    background: rgba(254, 240, 222, 0.3);
    border-radius: 0 0 5px 5px;
    padding: 0;
}

.accordion-body > .nav-link {
    line-height: 40px;
    text-align: left;
    margin-left: 5%;
}
</style>
