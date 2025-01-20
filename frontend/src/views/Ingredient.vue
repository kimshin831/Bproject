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
                    <select class="form-select" aria-label="Default select example">
                        <option selected>추천순</option>
                        <option value="1">인기순</option>
                        <option value="2">저가순</option>
                        <option value="3">고가순</option>
                    </select>
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
                        <div class="heart-img" @click.stop="toggleHeart(items)">
                            <img
                                :src="
                                    items.liked
                                        ? require('@/assets/img/heart-solid.svg')
                                        : require('@/assets/img/heart-regular.svg')
                                "
                                alt="하트이미지"
                                width="17"
                                height="17"
                            />
                        </div>
                        <p class="item_score"><img src="@/assets/img/leaf.svg" alt="score" /> 4.3점</p>
                        <p class="item_title">{{ items.title }}</p>
                        <p class="item_price">{{ items.price }} 원</p>
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
        goToDetail(id) {
            // 상세 페이지 이동
            this.$router.push({ name: 'ProductPage', params: { id } });
        },
        toggleHeart(product) {
            // 좋아요 상태 토글
            product.liked = !product.liked;
            // localStorage에 상태 저장
            localStorage.setItem(`liked_${product.id}`, product.liked);
        }
    },
    created() {
        this.item = CategoryItem.map((product) => {
            const savedLiked = localStorage.getItem(`liked_${product.id}`);
            return { ...product, liked: savedLiked === 'true' };
        });
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
.row {
    padding-bottom: 5px;
}
.col-auto {
    margin: 0;
    width: auto;
}
.form-select {
    font-size: 0.8em;
}
.form-check {
    font-size: 13px;
    letter-spacing: -0.2px;
    line-height: 35px;
}
.form-check-input {
    margin-top: 10px;
}
.form-check-input:checked {
    border: 0px;
    border-radius: 3px;
    background: url(@/assets/img/check.jpg) no-repeat center center;
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
    cursor: pointer;
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
.itemBox .itemText {
    position: relative;
    width: 100%;
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

.itemBox .itemText .item_score > img {
    margin-right: 5px;
    filter: invert(10%) sepia(89%) saturate(6058%) hue-rotate(83deg) brightness(108%) contrast(86%);
}
.heart-img {
    position: absolute;
    width: 30px;
    height: 30px;
    right: 5px;
    top: 0;
    z-index: 100;
    cursor: pointer;
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
    font-size: 1em;
    font-weight: 500;
}

.heart-img {
    position: absolute;
    width: 30px;
    height: 30px;
    right: 0;
    top: 0;
    z-index: 100;
    filter: invert(13%) sepia(90%) saturate(7298%) hue-rotate(355deg) brightness(90%) contrast(125%);
}

.margin {
    height: 67px;
}
</style>
