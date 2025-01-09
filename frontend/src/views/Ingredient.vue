<template>
    <div class="container-fluid">
        <TopButton title="성분별" />
        <!-- 탭 메뉴 영역 -->
        <div class="menu-swiper">
            <!-- Swiper 슬라이드 -->
            <swiper :slides-per-view="4" grabCursor="true">
                <swiper-slide
                    v-for="(item, index) in menuItems"
                    :key="index"
                    :class="{ active: activeTab === index }"
                    @click="setActiveTab(index)"
                >
                    {{ item.name }}
                </swiper-slide>
            </swiper>
        </div>
        <div class="tab-contents">
            <!-- 현재 activeTab에 해당하는 콘텐츠만 렌더링 -->
            <div v-if="menuItems[activeTab]">
                {{ menuItems[activeTab].content }}
            </div>
        </div>
        <div class="container text-center">
            <div class="row">
                <div class="col-auto me-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked />
                        <label class="form-check-label" for="flexCheckChecked"> 내 피부타입만 보기 </label>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button
                            class="btn btn-secondary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            추천순
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item" type="button">인기순</button></li>
                            <li><button class="dropdown-item" type="button">신상품순</button></li>
                            <li><button class="dropdown-item" type="button">저가순</button></li>
                            <li><button class="dropdown-item" type="button">고가순</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <!-- 상품  -->
            <div class="contents" v-if="activeTab === 0">
                <div class="itemBox" v-for="(items, i) in item" :key="i" @click="goToDetail(items.id)">
                    <div class="itemImg">
                        <img :src="items.image" alt="상품이미지" />
                    </div>
                    <div class="itemText">
                        <p class="item_tag">#000 #000 #000</p>
                        <p class="item_score"><img src="@/assets/img/leaf.svg" alt="score" /> 4.3점</p>
                        <p class="item_title">{{ items.title }}</p>
                        <p class="item_price">{{ items.price }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="margin"></div>
</template>
<script>
import TopButton from '../components/TopButton.vue';
import CategoryItem from '../assets/js/CategoryItem';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/swiper-bundle.css';

export default {
    name: 'Ingredient',
    components: {
        TopButton,
        Swiper,
        SwiperSlide
    },
    data() {
        return {
            item: CategoryItem,
            activeTab: 0,
            menuItems: [
                { name: '어성초', content: '어성초는 삼백초과의 식물로 여드름같은 트러블에 좋습니다.' },
                {
                    name: '콜라겐',
                    content:
                        '콜라겐은 뼈, 피부, 근육, 힘줄, 인대 등을 구성하는 단백질로 노화를 예방하기 위해 콜라겐을 보충하는 것이 좋습니다.'
                },
                {
                    name: '히알루론산',
                    content:
                        '히알루론산은 다당류의 일종 피부에 수분을 끌어당기고 유지하여, 피부를 촉촉하게 유지하고 건조함을 예방하는 역할을 합니다.'
                },
                { name: '판테놀', content: '.' },
                { name: '레티놀', content: '.' },
                { name: '달팽이', content: '.' },
                { name: '동백', content: '.' },
                { name: '세라마이드', content: '.' }
            ]
        };
    },
    methods: {
        setActiveTab(index) {
            this.activeTab = index;
        },
        goToDetail(items) {
            this.$router.push({
                name: 'ProductPage',
                params: {
                    id: items,
                    image: items.image,
                    title: items.title,
                    price: items.price
                }
            });
        }
    }
};
</script>
<style scoped>
/* 탭 내용 */
.menu-swiper {
    margin: 20px 0;
    font-size: 13px;
    text-align: center;
    display: flex;
    justify-content: space-between;
}
.swiper-slide {
    line-height: 33px;
    color: #a68151;
    font-weight: 700;
}

.swiper-slide.active {
    width: auto;
    height: auto;
    line-height: 24px;
    padding: 5px 10px;
    background: rgba(166, 129, 81, 0.6);
    border-radius: 15px;
    box-sizing: border-box;
    color: #fff;
    font-weight: 700;
}

.col-auto {
    margin: 10px 0;
    width: auto;
    height: 17px;
}

.form-check {
    font-size: 13px;
    letter-spacing: -0.2px;
}

.form-check-input:checked {
    border: 0px;
    border-radius: 3px;
    background: url(@/assets/img/check.jpg) no-repeat center center;
}

.dropdown {
    margin-top: -5px;
}

.dropdown > .btn {
    width: auto;
    height: 17px;
    font-size: 13px;
    line-height: 2px;
    background: #fff;
    border: 0px;
    color: #000;
    letter-spacing: -0.2px;
    padding: 0 3px;
}

.btn.btn-secondary.dropdown-toggle {
    background: #fff;
    color: #000;
}
.dropdown-menu {
    --bs-dropdown-link-active-bg: #fff;
    --bs-dropdown-link-active-color: #000;
}

.dropdown-menu.show {
    background: #fff;
    padding: 10px;
}

button.dropdown-item {
    padding-right: 5.5px;
    font-size: 13px;
    line-height: 25px;
    text-align: right;
}

button.dropdown-item:root {
    background: #fff;
}

/* 콘텐츠 */

.tab-contents {
    background: #f1f1f1;
    margin: -7px 0 8px 0;
    text-align: left;
    padding: 5px 15px;
    border-radius: 10px;
    font-size: 0.8rem;
    line-height: 1.3rem;
    letter-spacing: -0.2px;
}

/* 상품  */

.tab-content {
    margin: -7px 0 8px 0;
    text-align: left;
    padding: 5px 10px;
    letter-spacing: -0.2px;
}
.contents {
    margin: 0 auto;
    max-width: 390px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.itemBox {
    margin-bottom: 27px;
    width: 48%;
    height: auto;
}
.itemBox .itemImg {
    margin: 0 auto;
}
.itemBox .itemImg img {
    display: block;
    width: 170px;
    height: 170px;
    border-radius: 5px;
    margin-bottom: 3px;
}
.itemBox .itemText p {
    text-align: left;
    margin: 0;
    font-size: 0.85em;
    line-height: 21.5px;
}

.itemBox .itemText .item_tag {
    font-size: 12px;
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
    font-size: 0.9em;
    letter-spacing: -0.5px;
    height: 47px;
    font-weight: 700;
}
.itemBox .itemText .item_price {
    margin-top: 5px;
    font-size: 0.9em;
}

.itemBox .itemText .item_price::after {
    content: '원';
}

.margin {
    height: 67px;
}
</style>
