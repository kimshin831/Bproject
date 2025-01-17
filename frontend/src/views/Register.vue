<template>
    <div class="signup-container">
        <button type="button" class="backBtn" @click="goBack">
            <img src="../assets/img/chevron-left-solid.svg" alt="뒤로가기" width="20" height="20" />
        </button>
        <div class="logo">
            <img src="../assets/img/NEDE_logo.png" alt="NEDE logo" />
        </div>
        <h2>회원가입</h2>

        <!-- 메시지 표시 -->
        <div v-if="message" :class="`message ${messageType}`">{{ message }}</div>

        <form @submit.prevent="handleSignup">
            <input type="text" v-model="form.name" placeholder="이름 입력" required />
            <input type="text" v-model="form.username" placeholder="아이디 입력" required />
            <input type="password" v-model="form.password" placeholder="비밀번호 입력" required />
            <input type="password" v-model="form.confirmPassword" placeholder="비밀번호 재확인" required />
            <div v-if="passwordMismatch" class="error-message">비밀번호가 일치하지 않습니다.</div>

            <div class="birthdate-group">
                <select v-model="form.birthYear">
                    <option value="" disabled>년도</option>
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
                <select v-model="form.birthMonth">
                    <option value="" disabled>월</option>
                    <option v-for="month in months" :key="month" :value="month">{{ month }}</option>
                </select>
                <select v-model="form.birthDay">
                    <option value="" disabled>일</option>
                    <option v-for="day in days" :key="day" :value="day">{{ day }}</option>
                </select>
            </div>

            <div class="checkbox-group">
                <label>
                    <input type="checkbox" v-model="form.agreeAll" @change="toggleAllAgreements" />
                    약관 전체 동의
                </label>
                <label>
                    <input type="checkbox" v-model="form.agreeTerms" />
                    이용약관에 동의합니다.
                </label>
                <label>
                    <input type="checkbox" v-model="form.agreePrivacy" />
                    개인정보 수집 및 이용에 동의합니다.
                </label>
                <label>
                    <input type="checkbox" v-model="form.isOver14" />
                    만 14세 이상입니다.
                </label>
            </div>

            <button type="submit" :disabled="!isFormValid">가입하기</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        const currentYear = new Date().getFullYear();
        return {
            form: this.getInitialFormData(),
            message: '', // 서버 응답 메시지
            messageType: '', // 메시지 타입(success/error)
            years: Array.from({ length: 100 }, (_, i) => currentYear - i),
            months: Array.from({ length: 12 }, (_, i) => i + 1),
            days: Array.from({ length: 31 }, (_, i) => i + 1)
        };
    },
    computed: {
        isFormValid() {
            const { name, username, password, confirmPassword, agreeTerms, agreePrivacy, isOver14 } = this.form;
            return (
                name &&
                username &&
                password &&
                confirmPassword &&
                !this.passwordMismatch && // 비밀번호 불일치 검증
                agreeTerms &&
                agreePrivacy &&
                isOver14
            );
        },
        passwordMismatch() {
            return this.form.password && this.form.confirmPassword && this.form.password !== this.form.confirmPassword;
        }
    },
    watch: {
        // 개별 동의 항목이 변경될 때 전체 동의 체크박스 상태 업데이트
        'form.agreeTerms': 'updateAgreeAll',
        'form.agreePrivacy': 'updateAgreeAll',
        'form.isOver14': 'updateAgreeAll'
    },
    methods: {
        getInitialFormData() {
            return {
                name: '',
                username: '',
                password: '',
                confirmPassword: '',
                birthYear: new Date().getFullYear(), // 기본값: 현재 연도
                birthMonth: 1, // 기본값: 1월
                birthDay: 1, // 기본값: 1일
                agreeAll: false,
                agreeTerms: false,
                agreePrivacy: false,
                isOver14: false
            };
        },
        resetForm() {
            this.form = this.getInitialFormData();
        },
        toggleAllAgreements() {
            const agree = this.form.agreeAll;
            this.form = {
                ...this.form,
                agreeTerms: agree,
                agreePrivacy: agree,
                isOver14: agree
            };
        },
        updateAgreeAll() {
            // 개별 체크박스 상태에 따라 전체 동의 체크박스 업데이트
            this.form.agreeAll = this.form.agreeTerms && this.form.agreePrivacy && this.form.isOver14;
        },
        async handleSignup() {
            if (!this.isFormValid) {
                this.message = '모든 필드를 올바르게 입력해주세요.';
                this.messageType = 'error';
                return;
            }

            try {
                const response = await fetch('/api/auth/signup.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });
                const result = await response.json();
                if (result.status === 'success') {
                    this.message = '회원가입이 완료되었습니다!';
                    this.messageType = 'success';

                    this.resetForm();

                    setTimeout(() => {
                        this.$router.push('/login'); // 로그인 페이지로 이동
                    }, 2000);
                } else {
                    this.message = result.message || '회원가입 실패!';
                    this.messageType = 'error';
                }
            } catch (error) {
                this.message = '서버와 통신 중 문제가 발생했습니다.';
                this.messageType = 'error';
                console.error('Error:', error);
            }
        },
        goBack() {
            this.$router.go(-1); // 뒤로가기
        }
    }
};
</script>

<style scoped>
.signup-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    text-align: center;
}

.logo img {
    max-width: 100px;
    margin-bottom: 20px;
}
.signup-container h2 {
    margin: 7px;
    font-size: 20px;
    color: #333;
    text-align: left;
}

form {
    display: flex;
    flex-direction: column;
}

input,
select,
button {
    margin-bottom: 15px;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.backBtn {
    border: none;
    background-color: #fff;
    margin: 0;
    padding: 0;
    display: block;
    margin-bottom: 30px;
}
button:disabled {
    background-color: #aaa;
    cursor: not-allowed;
    color: #fff;
}

.checkbox-group {
    text-align: left;
    margin-bottom: 15px;
}

.checkbox-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
}

.birthdate-group {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.birthdate-group select {
    flex: 1;
    margin-right: 5px;
}

.birthdate-group select:last-child {
    margin-right: 0;
}

.message {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    font-size: 14px;
}

.message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.error-message {
    color: red;
    font-size: 14px;
    margin-bottom: 10px;
}
</style>
