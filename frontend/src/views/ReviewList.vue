<template>
    <div class="container">
        <TopButton title="리얼리뷰" />
        <div v-if="isLoading">리뷰를 불러오는 중...</div>
        <div v-else>
            <div class="reviewTop">
                <div class="search-container">
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="리뷰 제목 입력"
                        class="search-box"
                        @keyup.enter="applySearch"
                    />
                    <button @click="applySearch" class="search-button">검색</button>
                </div>

                <div v-if="filteredPosts.length > 0">
                    <!-- 검색된 게시글만 표시 -->
                    <div v-for="post in filteredPosts" :key="post.id" class="post-item">
                        <PostItem :post="post" @postDeleted="removePost" />
                    </div>
                </div>
                <div v-else class="no-posts">검색 결과가 없습니다.</div>

                <div class="review-bt-container">
                    <button class="reviewBtn" type="button" @click="navigateToCreate">리뷰작성하기 ></button>
                </div>
            </div>
            <!-- 리뷰 목록 -->
            <div class="contents">
                <div
                    class="reviewItem"
                    v-for="review in filteredPosts"
                    :key="review.id"
                    @click="navigateToDetail(review.user_id)"
                >
                    <div class="reviewImg">
                        <img :src="review.image_path" alt="리뷰 이미지" v-if="review.image_path" />
                    </div>
                    <div class="reviewContent">
                        <p class="title">{{ review.title }}</p>
                        <p class="content_r">{{ review.content }}</p>
                        <p class="score"><img src="@/assets/img/leaf.svg" alt="score" /> 4.3점</p>
                        <p>작성자ㅣ{{ review.username || '익명' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="margin"></div>
</template>

<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'ReviewList',
    components: {
        TopButton
    },
    data() {
        return {
            reviews: [], // 리뷰 데이터를 저장
            isLoading: false,
            filteredPosts: [], // 검색 결과 게시글 목록
            searchQuery: ''
        };
    },
    methods: {
        // 리뷰 목록 불러오기
        async fetchReviews() {
            this.isLoading = true; // 로딩 시작
            try {
                const response = await fetch('http://green609b.dothome.co.kr/api/posts/fetch_reviews.php');
                if (!response.ok) {
                    throw new Error(`리뷰 데이터를 가져오는 데 실패했습니다. 상태 코드: ${response.status}`);
                }
                this.reviews = await response.json();
                this.filteredPosts = this.reviews; // 초기에는 전체 게시글 표시
            } catch (error) {
                console.error('리뷰 데이터를 가져오는 중 오류 발생:', error);
                alert('리뷰 데이터를 불러오는 데 실패했습니다. 다시 시도해주세요.');
            } finally {
                this.isLoading = false; // 로딩 종료
            }
        },
        // 리뷰 작성 페이지로 이동
        navigateToCreate() {
            this.$router.push('/reviews/create');
        },
        // 리뷰 상세 페이지로 이동
        navigateToDetail(reviewId) {
            this.$router.push(`/reviews/${reviewId}`);
        },
        // 검색 실행 메서드
        applySearch() {
            const query = this.searchQuery.toLowerCase().trim();
            if (query) {
                // 검색어가 있을 경우 필터링
                this.filteredPosts = this.reviews.filter(
                    (review) => review.title && review.title.toLowerCase().includes(query)
                );
            } else {
                // 검색어가 없으면 전체 게시글 표시
                this.filteredPosts = this.reviews;
            }
        }
    },
    mounted() {
        this.fetchReviews(); // 컴포넌트가 마운트될 때 리뷰 데이터를 가져옴
    }
};
</script>

<style scoped>
/* 리뷰 */
.contents {
    width: 100%;
    margin: 0 auto;
    overflow: hidden;
}
.reviewTop {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 20px 0 15px 0;
}
.search-container {
    display: flex;
    align-items: center;
}
.search-container input {
    outline: none;
    height: 29px;
    border: 1px solid #b8b8b8;
    font-size: 0.9em;
    padding-left: 5px;
}
.search-button {
    border: 1px solid #a68151;
    height: 29px;
    font-size: 0.8rem;
    color: #f3f3f3;
    width: auto;
    padding: 0 10px;
    background-color: #a68151;
    font-weight: bold;
    letter-spacing: -0.1px;
    transition: all 0.3s;
}
.search-button:hover {
    background: #8d6c40;
}
.reviewBtn {
    border: none;
    background: none;
    font-size: 0.8rem;
    padding: 4px 7px;
    color: #a68151;
    font-weight: bold;
    box-sizing: border-box;
    border-radius: 5px;
    letter-spacing: -0.1px;
    transition: all 0.3s;
}
.reviewBtn:hover {
    color: #8d6c40;
}

.reviewItem {
    width: 98%;
    padding: 15px 0;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: transform 0.2s;
    border-bottom: 1px solid #ccc;
}
.reviewItem:hover {
    transform: scale(1.02);
}
.reviewImg {
    width: 125px;
    height: 150px;
    margin-right: 20px;
}
.reviewImg img {
    display: block;
    width: 125px;
    height: 150px;
    object-fit: cover;
}
.reviewContent {
    width: 100%;
    float: left;
    text-align: left;
}
.reviewContent p {
    margin: 0;
    padding-right: 20px;
    font-size: 0.85rem;
}

p.title {
    width: 63vw;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 1.2rem;
    font-weight: bold;
    line-height: 2rem;
}

p.content_r {
    width: 63vw;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 0.85rem;
    line-height: 1.2rem;
}

.score img {
    margin-right: 3px;
    filter: invert(10%) sepia(89%) saturate(6058%) hue-rotate(83deg) brightness(108%) contrast(86%);
}

p.score {
    font-size: 0.9rem;
    line-height: 2.5rem;
}

.margin {
    height: 63px;
}
</style>
