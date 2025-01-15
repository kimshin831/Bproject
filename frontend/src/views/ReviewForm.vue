<template>
    <div>
        <TopButton :title="isEditMode ? '리뷰 수정' : '리뷰 작성'" />
        <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
            <div>
                <label for="author">작성자 아이디 : </label>
                <input v-model="author" id="author" placeholder="작성자 아이디" readonly />
            </div>
            <div>
                <label for="title">화장품명 : </label>
                <input v-model="title" id="title" placeholder="리뷰 제목" required />
            </div>
            <div>
                <label for="image">사진 첨부하기 : </label>
                <input type="file" id="image" @change="handleFileUpload" accept="image/*" />
            </div>
            <div>
                <label for="content">내용 : </label>
                <textarea v-model="content" id="content" placeholder="리뷰 내용을 입력하세요" required></textarea>
            </div>
            <button type="submit">{{ isEditMode ? '리뷰 수정' : '리뷰 등록' }}</button>
        </form>
    </div>
</template>

<script>
import TopButton from '@/components/TopButton.vue';

export default {
    name: 'ReviewForm',
    components: {
        TopButton
    },
    data() {
        return {
            author: '', // 작성자 아이디
            title: '', // 리뷰 제목
            content: '', // 리뷰 내용
            image: null, // 새로 업로드할 이미지
            isEditMode: false, // 수정 모드 여부
            reviewId: null // 수정할 리뷰 ID
        };
    },
    methods: {
        // 로그인 상태 확인 및 작성자 아이디 설정
        async checkLoginStatus() {
            try {
                const response = await fetch('http://green609b.dothome.co.kr/api/auth/check_login.php', {
                    method: 'GET',
                    credentials: 'include' // 세션 쿠키 포함
                });
                const result = await response.json();

                if (result.logged_in) {
                    this.author = result.username; // 로그인된 사용자 ID 설정
                } else {
                    alert('로그인 상태가 아닙니다. 로그인 페이지로 이동합니다.');
                    this.$router.push('/login');
                }
            } catch (error) {
                console.error('로그인 상태 확인 중 오류 발생:', error);
            }
        },
        // 파일 업로드 처리
        handleFileUpload(event) {
            this.image = event.target.files[0];
        },
        // 기존 리뷰 데이터 가져오기
        async fetchReviewData() {
            try {
                const response = await fetch(
                    `http://green609b.dothome.co.kr/api/posts/fetch_review.php?id=${this.reviewId}`
                );
                if (!response.ok) {
                    throw new Error(`리뷰 데이터를 가져오는 데 실패했습니다. 상태 코드: ${response.status}`);
                }
                const review = await response.json();
                this.title = review.title;
                this.content = review.content;
                this.image = null; // 새 이미지를 첨부하지 않을 수도 있음
            } catch (error) {
                console.error('리뷰 데이터를 가져오는 중 오류 발생:', error);
                alert('리뷰 데이터를 불러오는 데 실패했습니다.');
            }
        },
        // 리뷰 등록 또는 수정
        async handleSubmit() {
            const formData = new FormData();
            formData.append('title', this.title);
            formData.append('content', this.content);
            if (this.image) {
                formData.append('image', this.image);
            }

            const apiUrl = this.isEditMode
                ? `http://green609b.dothome.co.kr/api/posts/update_review.php?id=${this.reviewId}`
                : 'http://green609b.dothome.co.kr/api/posts/create_review.php';

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });
                const result = await response.json();
                alert(result.message);

                if (result.status === 'success') {
                    this.$router.push('/reviews'); // 성공적으로 완료되면 목록으로 이동
                }
            } catch (error) {
                console.error('리뷰 작업 중 오류 발생:', error);
            }
        }
    },
    mounted() {
        this.checkLoginStatus();

        if (this.$route.params.id) {
            this.isEditMode = true;
            this.reviewId = this.$route.params.id; // 수정할 리뷰 ID 설정
            this.fetchReviewData(); // 기존 리뷰 데이터 로드
        }
    }
};
</script>

<style scoped>
form {
    width: 90%;
    max-width: 500px;
    margin: 0 auto; /* 가운데 정렬 */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: left;
}

/* 라벨 스타일 */
label {
    display: inline-block;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 14px;
    color: #333;
}

/* 입력 필드 스타일 */
input[type='text'],
input[type='file'],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    color: #555;
}
/* 입력 필드 포커스 스타일 */
input[type='text']:focus,
textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* 텍스트 에어리어 높이 조정 */
textarea {
    height: 150px;
    resize: vertical;
}

/* 버튼 스타일 */
button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #999;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #333;
}

/* 이미지 파일 선택 스타일 */
input[type='file'] {
    padding: 3px;
}
</style>
