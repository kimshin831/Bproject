<template>
    <div class="container">
        <TopButton title="상세리뷰" />
        <p class="title">{{ review.title }}</p>
        <div v-if="isLoading">리뷰를 불러오는 중...</div>
        <div v-else class="review-container">
            <div class="reviewImg">
                <img :src="review.image_path" alt="리뷰이미지" v-if="review.image_path" />
            </div>
            <div class="review-content">
                <p class="id">아이디ㅣ{{ review.username }}</p>
                <p class="score"><img src="@/assets/img/leaf.svg" alt="score" /> 4.3점</p>
                <p class="content">{{ review.content }}</p>
            </div>
            <div class="review-bottom">
                <div>
                    <button type="button" @click="ReviewList" class="bottom-Btn">
                        <img src="../assets/img/chevron-left-solid.svg" alt="뒤로가기" width="15" height="15" />
                        목록으로 돌아가기
                    </button>
                </div>
                <div class="buttons" v-if="isOwner">
                    <button type="button" @click="navigateToEdit">수정</button>ㅣ
                    <button type="button" @click="deleteReview">삭제</button>
                </div>
            </div>
        </div>
    </div>
    <div class="margin"></div>
</template>

<script>
import TopButton from '@/components/TopButton.vue';
import ReviewList from './ReviewList.vue';
export default {
    name: 'ReviewPage',
    components: { TopButton },
    data() {
        return {
            review: {}, // 리뷰 데이터 저장
            loggedInUser: null, // 로그인한 사용자 ID
            isOwner: false, // 작성자 여부 확인
            isLoading: true // 로딩 상태
        };
    },
    methods: {
        // 리뷰 데이터 가져오기
        async fetchReview() {
            this.isLoading = true;
            const reviewId = this.$route.params.id; // URL 파라미터에서 리뷰 ID 가져오기
            try {
                const response = await fetch(
                    `http://green609b.dothome.co.kr/api/posts/fetch_review.php?id=${reviewId}`
                );
                if (!response.ok) {
                    throw new Error(`리뷰를 가져오는 데 실패했습니다. 상태 코드: ${response.status}`);
                }
                const data = await response.json();
                this.review = data;

                // 작성자와 로그인 사용자 비교
                this.isOwner = this.review.username === this.loggedInUser;
            } catch (error) {
                console.error('리뷰 데이터를 가져오는 중 오류 발생:', error);
                alert('리뷰를 가져오는 데 실패했습니다. 다시 시도해주세요.');
            } finally {
                this.isLoading = false;
            }
        },
        // 로그인한 사용자 정보 가져오기
        async fetchLoggedInUser() {
            try {
                const response = await fetch('http://green609b.dothome.co.kr/api/auth/check_login.php', {
                    method: 'GET',
                    credentials: 'include' // 세션 쿠키 포함
                });
                const result = await response.json();
                if (result.logged_in) {
                    this.loggedInUser = result.username; // 로그인된 사용자 ID 저장
                    console.log('Logged-in user ID:', this.loggedInUser); // 디버깅 로그
                } else {
                    this.loggedInUser = null;
                }
            } catch (error) {
                console.error('로그인 사용자 정보를 가져오는 중 오류 발생:', error);
            }
        },
        // 수정 페이지로 이동
        navigateToEdit() {
            this.$router.push(`/reviews/edit/${this.review.user_id}`); // 수정 페이지로 이동
        },
        // 리뷰 삭제
        async deleteReview() {
            if (confirm('정말로 삭제하시겠습니까?')) {
                try {
                    const response = await fetch(`http://green609b.dothome.co.kr/api/posts/delete_review.php`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: this.review.user_id })
                    });
                    const result = await response.json();
                    alert(result.message);
                    if (result.status === 'success') {
                        this.$router.push('/reviews'); // 삭제 후 리뷰 목록으로 이동
                    }
                } catch (error) {
                    console.error('리뷰 삭제 중 오류 발생:', error);
                }
            }
        },
        ReviewList() {
            this.$router.push('/reviews');
        }
    },
    async mounted() {
        await this.fetchLoggedInUser(); // 로그인한 사용자 정보 가져오기
        await this.fetchReview(); // 리뷰 데이터 가져오기
    }
};
</script>

<style scoped>
.title {
    width: 90%;
    margin: 0 auto;
    margin-top: 30px;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
}

.reviewImg img {
    height: auto;
    object-fit: scale-down;
}

.reviewImg {
    background-color: #fff;
    margin: 0 auto;
    margin-top: 15px;
    width: 90%;
}
.reviewImg img {
    display: block;
    width: 100%;
    height: 500px;
}
.review-container {
    margin: 0 auto;
    width: 90%;
}
.review-content {
    margin: 0 auto;
    margin-top: 20px;
    width: 100%;
    margin-bottom: 10px;
}

.id {
    float: right;
    font-size: 0.9rem;
}

.score {
    font-size: 1.05rem;
}

.score img {
    margin-right: 3px;
    filter: invert(10%) sepia(89%) saturate(6058%) hue-rotate(83deg) brightness(108%) contrast(86%);
}

.content {
    width: 100%;
    min-height: 150px;
    text-align: justify;
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    padding: 15px 0;
}
.review-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.bottom-Btn {
    border: none;
    background-color: #fff;
    font-size: 0.9em;
    display: flex;
    align-items: center;
    gap: 3px;
}
.buttons button {
    border: none;
    background-color: #fff;
    font-size: 0.9em;
}
.buttons button:hover {
    text-decoration: underline;
}
.bottom-Btn:hover {
    text-decoration: underline;
}
.margin {
    height: 63px;
}
</style>
