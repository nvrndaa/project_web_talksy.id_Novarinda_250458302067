<section class="section-padding bg-white overflow-hidden relative">
    <div class="container flex flex-col lg:flex-row items-center gap-16">

        <div class="lg:w-1/2 z-10">
            <h2 class="section-title">Evaluasi & Dapatkan Sertifikat</h2>
            <p class="section-subtitle mx-0! max-w-none! text-left mb-8">
                Setiap modul diakhiri dengan kuis untuk memastikan pemahaman Anda. Sistem kami akan mencatat skor dan memberikan sertifikat jika Anda lulus (<i>Passing Score: 70</i>).
            </p>

            <div class="flex gap-4 mb-8">
                <div class="pl-4 border-l-4 border-accent">
                    <h4 class="font-bold text-slate-800">Real-time Score</h4>
                    <p class="text-sm text-slate-500">Hasil langsung keluar</p>
                </div>
                <div class="pl-4 border-l-4 border-accent">
                    <h4 class="font-bold text-slate-800">Repeatable</h4>
                    <p class="text-sm text-slate-500">Ulangi sampai paham</p>
                </div>
            </div>
        </div>

        <div class="lg:w-1/2 w-full">
            <div class="bg-white rounded-2xl shadow-2xl border border-slate-100 p-8 relative">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-accent/10 rounded-full blur-3xl"></div>

                <div x-data="{
                    selectedOption: null,
                    options: ['Tuntutlah ilmu walau ke negeri China', 'Tuntutlah ilmu dari buaian hingga liang lahat', 'Bekerjalah seolah hidup selamanya', 'Ilmu adalah cahaya'],
                    correctAnswerIndex: 1,
                    isCorrect: null,
                    checkAnswer() {
                        this.isCorrect = (this.selectedOption === this.correctAnswerIndex);
                    }
                }">
                    <div class="flex justify-between mb-6">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Quiz Preview</span>
                        <span class="text-xs font-bold text-primary">Question 1 of 5</span>
                    </div>

                    <h4 class="text-xl font-bold text-slate-800 mb-6">
                        Apa terjemahan yang paling tepat untuk: <br>
                        <span class="text-primary italic">"Seek knowledge from cradle to grave"</span>?
                    </h4>

                    <div class="space-y-3">
                        <template x-for="(option, index) in options" :key="index">
                            <button @click="selectedOption = index; checkAnswer()"
                                    class="w-full text-left p-4 rounded-xl border transition-all duration-200 flex items-center justify-between"
                                    :class="{
                                        'border-primary bg-primary/5 text-primary font-semibold': selectedOption === index,
                                        'border-slate-200 hover:border-slate-300 text-slate-600': selectedOption !== index
                                    }">
                                <span x-text="option"></span>

                                <div x-show="selectedOption === index" class="w-5 h-5 rounded-full bg-primary text-white flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </button>
                        </template>
                    </div>

                    <div x-show="selectedOption !== null" x-transition class="mt-6 p-4 rounded-lg bg-slate-50 border border-slate-100 text-center">
                        <p class="text-sm" :class="isCorrect ? 'text-emerald-600 font-bold' : 'text-red-500'">
                            <span x-text="isCorrect ? 'Benar! Masya Allah, Excellent.' : 'Kurang tepat, coba lagi.'"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
