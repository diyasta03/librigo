@extends('layouts.guest')

@section('title', 'Baca Buku')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
            <div class="p-6 md:p-8 bg-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-2xl md::text-3xl font-bold text-gray-900">{{ $book->title }}</h1>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                {{ $book->category->name }}
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $book->user->name }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $book->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Buku</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $book->description }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm h-[70vh] mb-6 relative">
                    <div id="loadingIndicator" class="absolute inset-0 bg-white bg-opacity-80 flex items-center justify-center z-10">
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
                            <p class="mt-3 text-gray-600">Memuat buku...</p>
                        </div>
                    </div>
                    
                    <iframe 
                        id="bookViewer"
                        src="{{ env('SUPABASE_STORAGE_URL') . '/' . $book->file_path }}" 
                        class="w-full h-full" 
                        frameborder="0"
                        onload="document.getElementById('loadingIndicator').style.display = 'none';"
                        onerror="document.getElementById('loadingIndicator').innerHTML = '<p class=\"text-red-500\">Gagal memuat buku. Silakan coba lagi.</p>';">
                    </iframe>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Dengarkan Buku (Text-to-Speech)</h3>
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <div class="flex items-center gap-2">
                            <button id="playTts" class="p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                </svg>
                            </button>
                            <button id="pauseTts" class="p-3 bg-gray-300 rounded-full hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button id="stopTts" class="p-3 bg-gray-300 rounded-full hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label for="voiceSelect" class="block text-sm font-medium text-gray-700 mb-1">Suara</label>
                                <select id="voiceSelect" class="w-full text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih Suara</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="languageSelect" class="block text-sm font-medium text-gray-700 mb-1">Bahasa</label>
                                <select id="languageSelect" class="w-full text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                                    <option value="id-ID">Indonesia</option>
                                    <option value="en-US">English</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="rateControl" class="block text-sm font-medium text-gray-700 mb-1">Kecepatan: <span id="rateValue">1x</span></label>
                                <input type="range" id="rateControl" min="0.5" max="2" step="0.1" value="1" class="w-full">
                            </div>
                        </div>
                    </div>
                    
                    <div id="ttsStatus" class="mt-2 text-sm text-gray-600"></div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                    <a href="{{ route('books.index') }}" 
                       class="px-5 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200 flex items-center gap-2">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                       </svg>
                       Kembali ke Daftar Buku
                    </a>
                    
                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 transition duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            Suka
                        </button>
                        <button class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Komentar
                        </button>
                        <button class="px-4 py-2 bg-purple-100 text-purple-800 rounded-lg hover:bg-purple-200 transition duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script>
// Set PDF.js worker path
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

document.addEventListener('DOMContentLoaded', function() {
    const synth = window.speechSynthesis;
    const playBtn = document.getElementById('playTts');
    const pauseBtn = document.getElementById('pauseTts');
    const stopBtn = document.getElementById('stopTts');
    const voiceSelect = document.getElementById('voiceSelect');
    const languageSelect = document.getElementById('languageSelect');
    const rateControl = document.getElementById('rateControl');
    const rateValue = document.getElementById('rateValue');
    const ttsStatus = document.getElementById('ttsStatus'); 
    
    let currentUtterance = null;
    let speakingQueue = []; 
    let isSpeaking = false;
    let currentTextIndex = 0;
    let isTextExtractionComplete = false; 

    let bookContentToSpeak = `{{ $book->title }}. {{ $book->description }}`; 
    
    function chunkText(text, maxLength = 200) { 
        const chunks = [];
        let i = 0;
        while (i < text.length) {
            let chunk = text.substring(i, Math.min(i + maxLength, text.length));
            let lastSentenceEnd = Math.max(chunk.lastIndexOf('.'), chunk.lastIndexOf('?'), chunk.lastIndexOf('!'));
            let lastLineBreak = chunk.lastIndexOf('\n');
            let lastSpace = chunk.lastIndexOf(' ');

            let splitIndex = -1;
            if (lastSentenceEnd !== -1 && lastSentenceEnd > maxLength * 0.8) {
                splitIndex = lastSentenceEnd + 1;
            } else if (lastLineBreak !== -1 && lastLineBreak > maxLength * 0.8) {
                splitIndex = lastLineBreak + 1;
            } else if (lastSpace !== -1 && lastSpace > maxLength * 0.8) {
                splitIndex = lastSpace + 1;
            }

            if (splitIndex !== -1 && splitIndex <= chunk.length) {
                chunk = chunk.substring(0, splitIndex);
            } else {
                chunk = chunk.substring(0, maxLength); 
            }

            if (chunk.trim().length > 0) {
                chunks.push(chunk.trim());
            }
            i += chunk.length;
        }
        return chunks;
    }

    function updateTtsStatus(message, color = 'text-gray-600') {
        ttsStatus.textContent = message;
        ttsStatus.className = `text-sm ${color}`;
    }

    function extractTextFromPDF() {
        const rawFilePath = "{{ $book->file_path }}";
        const cleanedFilePath = rawFilePath.trim().toLowerCase();
        
        const pdfUrl = "{{ env('SUPABASE_STORAGE_URL') . '/' }}" + rawFilePath;
        
        updateTtsStatus('Mempersiapkan teks untuk dibacakan...', 'text-blue-600');
        playBtn.disabled = true; 
        pauseBtn.disabled = true;
        stopBtn.disabled = true;

        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        
        loadingTask.promise.then(function(pdf) {
            const totalPages = pdf.numPages;
            let combinedTextFromPdf = '';
            const pagePromises = [];
            
            const pagesToExtract = Math.min(totalPages, 50);

            for (let i = 1; i <= pagesToExtract; i++) {
                pagePromises.push(pdf.getPage(i).then(function(page) {
                    return page.getTextContent().then(function(text) {
                        const pageText = text.items.map(item => item.str).join(' ');
                        return pageText;
                    });
                }));
            }
            
            Promise.all(pagePromises).then(function(pagesText) {
                combinedTextFromPdf = pagesText.join('\n\n'); 
                bookContentToSpeak += '\n\n' + combinedTextFromPdf;

                const MAX_CHARS_FOR_TTS = 100000; 
                bookContentToSpeak = bookContentToSpeak.substring(0, MAX_CHARS_FOR_TTS); 

                isTextExtractionComplete = true; 
                prepareSpeechQueue(); 
                updateTtsStatus('Buku siap dibacakan.');
                playBtn.disabled = false; 
                pauseBtn.disabled = false;
                stopBtn.disabled = false;
            }).catch(function(error) {
                console.error('Gagal mengekstrak teks dari halaman:', error); 
                updateTtsStatus('Hanya membaca judul dan deskripsi (PDF mungkin tidak memiliki teks yang dapat dibaca).', 'text-orange-500');
                isTextExtractionComplete = true; 
                prepareSpeechQueue(); 
                playBtn.disabled = false;
                pauseBtn.disabled = false;
                stopBtn.disabled = false;
            });
        }).catch(function(error) {
            console.error('Gagal memuat dokumen PDF:', error); 
            updateTtsStatus('Hanya membaca judul dan deskripsi (PDF tidak dapat dimuat).', 'text-orange-500');
            isTextExtractionComplete = true;
            prepareSpeechQueue();
            playBtn.disabled = false;
            pauseBtn.disabled = false;
            stopBtn.disabled = false;
        });
    }

    const bookFilePathForCheck = "{{ $book->file_path }}".trim().toLowerCase();
    if (bookFilePathForCheck.endsWith('.pdf')) {
        extractTextFromPDF();
    } else {
        prepareSpeechQueue();
        isTextExtractionComplete = true; 
        updateTtsStatus('Buku siap dibacakan (bukan format PDF).');
        playBtn.disabled = false;
        pauseBtn.disabled = false;
        stopBtn.disabled = false;
    }
    
    function prepareSpeechQueue() {
        synth.cancel(); 
        speakingQueue = [];
        currentTextIndex = 0;
        speakingQueue = chunkText(bookContentToSpeak); 
    }
    
    function populateVoices() {
        voiceSelect.innerHTML = '<option value="">Pilih Suara</option>';
        const voices = synth.getVoices();
        const selectedLanguage = languageSelect.value;
        
        voices.forEach(voice => {
            if (voice.lang.includes(selectedLanguage)) {
                const option = document.createElement('option');
                option.textContent = `${voice.name} (${voice.lang})`;
                option.setAttribute('data-name', voice.name);
                option.setAttribute('data-lang', voice.lang);
                voiceSelect.appendChild(option);
            }
        });
        
        if (voiceSelect.selectedIndex === 0 && voiceSelect.options.length > 1) {
            const defaultVoice = Array.from(voices).find(voice => 
                voice.lang.includes(selectedLanguage) && voice.default
            );
            if (defaultVoice) {
                voiceSelect.querySelector(`option[data-name="${defaultVoice.name}"]`).selected = true;
            } else {
                voiceSelect.selectedIndex = 1; 
            }
        }
    }
    
    populateVoices();
    if (speechSynthesis.onvoiceschanged !== undefined) {
        speechSynthesis.onvoiceschanged = populateVoices;
    }
    
    languageSelect.addEventListener('change', function() {
        populateVoices();
        if (isSpeaking) {
            synth.cancel();
            isSpeaking = false; 
            currentTextIndex = 0; 
            prepareSpeechQueue();
            startSpeaking();
        } else {
            prepareSpeechQueue();
        }
    });

    function updatePlayButtonIcon(playing) {
        if (playing) {
            playBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 011.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
        } else {
            playBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" /></svg>';
        }
    }

    function startSpeaking() {
        if (currentTextIndex >= speakingQueue.length) {
            isSpeaking = false;
            updatePlayButtonIcon(false);
            updateTtsStatus('Pembacaan selesai.');
            return;
        }

        const textChunk = speakingQueue[currentTextIndex];
        currentUtterance = new SpeechSynthesisUtterance(textChunk);
        currentUtterance.lang = languageSelect.value;
        
        const selectedOption = voiceSelect.selectedOptions[0]?.getAttribute('data-name');
        if (selectedOption) {
            const voices = synth.getVoices();
            currentUtterance.voice = voices.find(voice => voice.name === selectedOption);
        }
        
        currentUtterance.rate = parseFloat(rateControl.value);
        currentUtterance.pitch = 1;
        
        currentUtterance.onend = function() {
            currentTextIndex++;
            startSpeaking(); 
        };
        
        currentUtterance.onerror = function(event) {
            console.error('SpeechSynthesisUtterance.onerror', event);
            isSpeaking = false;
            updatePlayButtonIcon(false);
            updateTtsStatus('Terjadi kesalahan saat membaca teks.', 'text-red-500');
        };

        synth.speak(currentUtterance);
        isSpeaking = true;
        updatePlayButtonIcon(true);
        updateTtsStatus(`Sedang membaca...`);
    }

    playBtn.addEventListener('click', function() {
        if (!isTextExtractionComplete) {
            updateTtsStatus('Sedang mempersiapkan buku...', 'text-orange-500');
            return;
        }

        if (synth.paused && isSpeaking) {
            synth.resume();
            updatePlayButtonIcon(true);
            updateTtsStatus('Membaca (dilanjutkan)...');
        } else if (!isSpeaking) {
            currentTextIndex = 0;
            prepareSpeechQueue();
            startSpeaking();
        }
    });
    
    pauseBtn.addEventListener('click', function() {
        if (synth.speaking) {
            synth.pause();
            isSpeaking = true; 
            updatePlayButtonIcon(false);
            updateTtsStatus('Pembacaan dijeda.');
        }
    });
    
    stopBtn.addEventListener('click', function() {
        synth.cancel();
        isSpeaking = false;
        currentTextIndex = 0; 
        updatePlayButtonIcon(false);
        updateTtsStatus('Pembacaan dihentikan.');
    });
    
    voiceSelect.addEventListener('change', function() {
        if (synth.speaking && currentUtterance) {
            synth.cancel();
            isSpeaking = false; 
            startSpeaking();
        }
    });
    
    rateControl.addEventListener('input', function() {
        const rate = parseFloat(rateControl.value);
        rateValue.textContent = rate.toFixed(1) + 'x';
        
        if (currentUtterance) {
            currentUtterance.rate = rate;
        }
    });
    
    setTimeout(() => {
        const loadingIndicator = document.getElementById('loadingIndicator');
        const iframe = document.getElementById('bookViewer');
        if (loadingIndicator && iframe && !iframe.contentDocument?.body?.innerHTML) {
            loadingIndicator.innerHTML = '<p class="text-orange-500">Buku masih dimuat. Jika terlalu lama, silakan periksa koneksi internet Anda.</p>';
        }
    }, 5000);
});
</script>
@endsection