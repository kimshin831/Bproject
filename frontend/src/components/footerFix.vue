<template>
    <div class="footerWrap">
        <ul class="nav justify-content-center">
            <!-- 카테고리 버튼 -->
            <li class="nav-item">
                <button class="btn btn-primary" type="button" @click="toggleOffcanvas">
                    <img src="../assets/img/bars-solid.png" alt="logo" width="19" height="auto" />
                    <p>카테고리</p>
                </button>

                <!-- 오프캔버스 -->
                <div
                    class="offcanvas offcanvas-start"
                    :class="{ show: isOffcanvasOpen }"
                    tabindex="-1"
                    id="offcanvasWithBothOptions"
                >
                    <button type="button" class="btn-close" @click="closeOffcanvas" aria-label="Close"></button>
                    <div class="offcanvas-header">
                        <!-- 아코디언 메뉴 -->
                        <div class="accordion">
                            <!-- BEST ITEM -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        :class="{ collapsed: !activeAccordion.includes('collapseOne') }"
                                        @click="toggleAccordion('collapseOne')"
                                    >
                                        BEST ITEM
                                    </button>
                                </h2>
                                <div
                                    id="collapseOne"
                                    class="accordion-collapse"
                                    :class="{ show: activeAccordion.includes('collapseOne') }"
                                >
                                    <div class="accordion-body">
                                        <router-link class="nav-link" to="/best-item" @click.native="closeOffcanvas"
                                            >BEST ITEM</router-link
                                        >
                                    </div>
                                </div>
                            </div>
                            <!-- 카테고리별 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        :class="{ collapsed: !activeAccordion.includes('collapseTwo') }"
                                        @click="toggleAccordion('collapseTwo')"
                                    >
                                        카테고리별
                                    </button>
                                </h2>
                                <div
                                    id="collapseTwo"
                                    class="accordion-collapse"
                                    :class="{ show: activeAccordion.includes('collapseTwo') }"
                                >
                                    <div class="accordion-body">
                                        <router-link class="nav-link" to="/category" @click.native="closeOffcanvas"
                                            >비누/ 클랜징</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >마스크/ 팩/ 필링</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >스킨/토너/미스트</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >앰플/에센스/세럼</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >수분젤/에센셜</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >로션/크림</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >썬케어</router-link
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        :class="{ collapsed: !activeAccordion.includes('collapseThree') }"
                                        @click="toggleAccordion('collapseThree')"
                                    >
                                        기능별
                                    </button>
                                </h2>
                                <div
                                    id="collapseThree"
                                    class="accordion-collapse"
                                    :class="{ show: activeAccordion.includes('collapseThree') }"
                                >
                                    <div class="accordion-body">
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >시카</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >미백/화이트닝</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >장벽케어</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >안티에이징</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >각질관리</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >남성용</router-link
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        :class="{ collapsed: !activeAccordion.includes('collapseFour') }"
                                        @click="toggleAccordion('collapseFour')"
                                    >
                                        성분별
                                    </button>
                                </h2>
                                <div
                                    id="collapseFour"
                                    class="accordion-collapse"
                                    :class="{ show: activeAccordion.includes('collapseFour') }"
                                >
                                    <div class="accordion-body">
                                        <router-link class="nav-link" to="/ingredient" @click.native="closeOffcanvas"
                                            >어성초</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >콜라겐</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >히알루론산</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >판테놀</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >레티놀</router-link
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        :class="{ collapsed: !activeAccordion.includes('collapseFive') }"
                                        @click="toggleAccordion('collapseFive')"
                                    >
                                        고민별
                                    </button>
                                </h2>
                                <div
                                    id="collapseFive"
                                    class="accordion-collapse"
                                    :class="{ show: activeAccordion.includes('collapseFive') }"
                                >
                                    <div class="accordion-body">
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >트러블</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >주름</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >모공/피지</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >수부지</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >탈모케어</router-link
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        :class="{ collapsed: !activeAccordion.includes('collapseSix') }"
                                        @click="toggleAccordion('collapseSix')"
                                    >
                                        Community
                                    </button>
                                </h2>
                                <div
                                    id="collapseSix"
                                    class="accordion-collapse"
                                    :class="{ show: activeAccordion.includes('collapseSix') }"
                                >
                                    <div class="accordion-body">
                                        <router-link class="nav-link" to="/reviews" @click.native="closeOffcanvas"
                                            >리뷰</router-link
                                        >
                                        <router-link class="nav-link" to="/event" @click.native="closeOffcanvas"
                                            >EVENT</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >문의하기</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >안티에이징</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >FAQ</router-link
                                        >
                                        <router-link class="nav-link" to="" @click.native="closeOffcanvas"
                                            >공지사항</router-link
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/qna" @click="offcanvershide">
                    <div class="nav_icon">
                        <img src="../assets/img/qna.svg" alt="qna" />
                        <p>Q&A</p>
                    </div>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/" @click="offcanvershide">
                    <div class="nav_icon">
                        <img src="../assets/img/NEDE_logo.png" alt="logo" class="nav_logo" />
                    </div>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/reviews" @click="offcanvershide">
                    <div class="nav_icon">
                        <img src="../assets/img/real.svg" alt="review" />
                        <p>리얼리뷰</p>
                    </div>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/mypage" @click="offcanvershide">
                    <div class="nav_icon">
                        <img src="../assets/img/user.svg" alt="mypage" />
                        <p>마이페이지</p>
                    </div>
                </router-link>
            </li>
        </ul>
    </div>
</template>
<script>
import { useRouter } from 'vue-router';
import { ref } from 'vue';

export default {
    name: 'footerFix',
    setup() {
        const isOffcanvasOpen = ref(false);
        const activeAccordion = ref([]);

        // 오프캔버스 열기/닫기
        const toggleOffcanvas = () => {
            isOffcanvasOpen.value = !isOffcanvasOpen.value;
        };

        const closeOffcanvas = () => {
            isOffcanvasOpen.value = false;
        };

        // 아코디언 토글
        const toggleAccordion = (id) => {
            if (activeAccordion.value.includes(id)) {
                // 이미 열려 있다면 닫기
                activeAccordion.value = activeAccordion.value.filter((item) => item !== id);
            } else {
                // 닫혀 있다면 열기
                activeAccordion.value = [id];
            }
        };

        return {
            isOffcanvasOpen,
            activeAccordion,
            toggleOffcanvas,
            closeOffcanvas,
            toggleAccordion
        };
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
    box-shadow: 2px 2px 2px 2px gray;
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
.accordion-collapse {
    display: none; /* 기본적으로 닫힌 상태 */
}

.accordion-collapse.show {
    display: block; /* 열릴 때 표시 */
}

.accordion-button.collapsed::after {
    content: '▼'; /* 닫힌 상태의 화살표 */
}

.accordion-button:not(.collapsed)::after {
    content: '▲'; /* 열린 상태의 화살표 */
}
</style>
