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
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBothOptions" ref="offcanvas">
                    <button type="button" class="btn-close" aria-label="Close" @click="closeOffcanvas"></button>
                    <div class="offcanvas-header">
                        <!-- 아코디언 메뉴 -->
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
                                        <router-link class="nav-link" to="/best-item" @click="closeOffcanvas">
                                            BEST ITEM
                                        </router-link>
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
                                        <router-link class="nav-link" to="/category" @click="closeOffcanvas"
                                            >비누/ 클랜징</router-link
                                        >
                                        <router-link class="nav-link" to="/category/mask" @click="closeOffcanvas"
                                            >마스크/ 팩/ 필링</router-link
                                        >
                                        <router-link class="nav-link" to="/category/toner" @click="closeOffcanvas"
                                            >스킨/토너/미스트</router-link
                                        >
                                        <router-link class="nav-link" to="/category/serum" @click="closeOffcanvas"
                                            >앰플/에센스/세럼</router-link
                                        >
                                        <router-link class="nav-link" to="/category/moisture" @click="closeOffcanvas"
                                            >수분젤/에센셜</router-link
                                        >
                                        <router-link class="nav-link" to="/category/lotion" @click="closeOffcanvas"
                                            >로션/크림</router-link
                                        >
                                        <router-link class="nav-link" to="/category/suncare" @click="closeOffcanvas"
                                            >썬케어</router-link
                                        >
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
                                        <a class="nav-link" @click="closeOffcanvas">시카</a>
                                        <a class="nav-link" @click="closeOffcanvas">미백/ 화이트닝</a>
                                        <a class="nav-link" @click="closeOffcanvas">장벽케어</a>
                                        <a class="nav-link" @click="closeOffcanvas">안티에이징</a>
                                        <a class="nav-link" @click="closeOffcanvas">각질관리</a>
                                        <a class="nav-link" @click="closeOffcanvas">남성용</a>
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
                                        <router-link class="nav-link" to="/ingredient" @click="closeOffcanvas"
                                            >어성초</router-link
                                        >
                                        <router-link class="nav-link" to="/ingredient/collagen" @click="closeOffcanvas"
                                            >콜라겐</router-link
                                        >
                                        <router-link
                                            class="nav-link"
                                            to="/ingredient/hyaluronic"
                                            @click="closeOffcanvas"
                                            >히알루론산</router-link
                                        >
                                        <router-link class="nav-link" to="/ingredient/panthenol" @click="closeOffcanvas"
                                            >판테놀</router-link
                                        >
                                        <router-link class="nav-link" to="/ingredient/retinol" @click="closeOffcanvas"
                                            >레티놀</router-link
                                        >
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
                                        <router-link class="nav-link" to="/reviews" @click="closeOffcanvas"
                                            >Reviw</router-link
                                        >
                                        <router-link class="nav-link" to="/event" @click="closeOffcanvas"
                                            >EVENT</router-link
                                        >
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
                <router-link class="nav-link" to="/qna" @click="closeOffcanvas">
                    <div class="nav_icon">
                        <img src="../assets/img/qna.svg" alt="qna" />
                        <p>Q&A</p>
                    </div>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/" @click="closeOffcanvas">
                    <div class="nav_icon">
                        <img src="../assets/img/NEDE_logo.png" alt="logo" class="nav_logo" />
                    </div>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/reviews" @click="closeOffcanvas">
                    <div class="nav_icon">
                        <img src="../assets/img/real.svg" alt="review" />
                        <p>리얼리뷰</p>
                    </div>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/mypage" @click="closeOffcanvas">
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
import { onMounted, onUnmounted, ref, nextTick } from 'vue';

export default {
    name: 'footerFix',
    setup() {
        const offcanvasRef = ref(null); // 오프캔버스 DOM 참조
        let offcanvasInstance = null; // Bootstrap Offcanvas 인스턴스

        // 오프캔버스 초기화
        const initializeOffcanvas = async () => {
            await nextTick(); // DOM이 완전히 렌더링된 후 초기화
            if (offcanvasRef.value) {
                // 기존 인스턴스를 제거하고 새로 생성
                if (offcanvasInstance) {
                    offcanvasInstance.dispose();
                }
                offcanvasInstance = new bootstrap.Offcanvas(offcanvasRef.value);

                // Bootstrap 이벤트 등록
                offcanvasRef.value.addEventListener('shown.bs.offcanvas', () => {
                    console.log('오프캔버스가 열렸습니다.');
                });
                offcanvasRef.value.addEventListener('hidden.bs.offcanvas', () => {
                    console.log('오프캔버스가 닫혔습니다.');
                });
            }
        };

        // 오프캔버스 열기/닫기 토글
        const toggleOffcanvas = async () => {
            await initializeOffcanvas(); // 초기화 보장
            if (offcanvasInstance) {
                const isVisible = offcanvasRef.value.classList.contains('show');
                if (isVisible) {
                    offcanvasInstance.hide();
                } else {
                    offcanvasInstance.show();
                }
            }
        };

        // 오프캔버스 닫기
        const closeOffcanvas = () => {
            if (offcanvasInstance) {
                offcanvasInstance.hide();
            }
        };

        // 컴포넌트가 마운트되면 초기화
        onMounted(() => {
            initializeOffcanvas();
        });

        // 컴포넌트가 언마운트되면 정리
        onUnmounted(() => {
            if (offcanvasInstance) {
                offcanvasInstance.dispose(); // 인스턴스 정리
                offcanvasInstance = null;
            }
        });

        return {
            toggleOffcanvas,
            closeOffcanvas,
            offcanvas: offcanvasRef
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
    box-shadow: 1px 1px 1px 1px gray;
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
