<template>
    <button @click="goBack">
        <img src="../assets/img/chevron-left-solid.svg" alt="뒤로가기" width="20" height="20" />
    </button>
    <div class="login-container">
        <div class="logo">
            <img src="../assets/img/nede_3.jpg" alt="NEDE logo" />
        </div>

        <form @submit.prevent="handleLogin">
            <input type="text" v-model="form.username" placeholder="아이디" required />
            <input
                type="password"
                v-model="form.password"
                placeholder="비밀번호(8~10자, 영문+숫자+특수문자)"
                required
            />
            <div class="options">
                <label> <input type="checkbox" v-model="form.autoLogin" /> 자동로그인 </label>
                <label> <input type="checkbox" v-model="form.saveId" /> 아이디 저장 </label>
            </div>

            <button type="submit" :disabled="loading">로그인</button>
            <button type="button" @click="Easylogin">간편 로그인</button>

            <div class="links">
                <button @click="navigateTo('/register')">회원가입</button>
                <button @click="navigateTo('#')">아이디 찾기</button>
                <button @click="navigateTo('#')">비밀번호 찾기</button>
            </div>
        </form>

        <footer>
            <span>ver.1.1.1 업데이트</span>
            <span>고객센터</span>
            <span>공지사항</span>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                username: '',
                password: '',
                autoLogin: false,
                saveId: false
            },
            loading: false,
            message: ''
        };
    },
    methods: {
        async handleLogin() {
            if (!this.form.username || !this.form.password) {
                alert('아이디와 비밀번호를 입력해주세요.');
                return;
            }

            this.loading = true;
            try {
                const response = await fetch('http://green609b.dothome.co.kr/api/auth/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        credentials: 'include'
                    },
                    body: JSON.stringify(this.form)
                });

                const result = await response.json();
                if (result.status === 'success') {
                    alert('로그인 성공!');
                    this.$router.push('/mypage'); // 메인 페이지로 이동
                } else {
                    alert(result.message || '로그인 실패!');
                }
            } catch (error) {
                alert('서버와 통신 중 문제가 발생했습니다.');
                console.error('Error:', error);
            } finally {
                this.loading = false;
            }
        },
        Easylogin() {
            this.$router.push('/easylogin');
        },
        navigateTo(path) {
            this.$router.push(path);
        },
        goBack() {
            this.$router.go(-1); // 뒤로가기
        }
    }
};
</script>

<style scoped>
.login-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
    font-family: Arial, sans-serif;
}

.logo img {
    max-width: 100px;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

input,
button {
    margin-bottom: 15px;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
}

button:disabled {
    background-color: #aaa;
    cursor: not-allowed;
}

.options {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.links {
    display: flex;
    justify-content: space-between;
}

footer {
    margin-top: 20px;
    font-size: 12px;
    display: flex;
    justify-content: space-between;
    color: #555;
}
</style>
