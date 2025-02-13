@extends('layouts/layoutMaster')

@section('title', 'Patient Dashboard')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="row mb-12 g-4">
    @php
        $clinics = [
            ['name' => 'Cardiology', 'image' => 'https://via.placeholder.com/150', 'description' => 'Expert heart care and cardiovascular treatments.'],
            ['name' => 'Dentistry', 'image' => 'https://via.placeholder.com/150', 'description' => 'Comprehensive dental services for all ages.'],
            ['name' => 'Neurology', 'image' => 'https://via.placeholder.com/150', 'description' => 'Advanced brain and nervous system care.'],
            ['name' => 'Orthopedics', 'image' => 'https://via.placeholder.com/150', 'description' => 'Bone and joint health specialists.'],
            ['name' => 'Pediatrics', 'image' => 'https://via.placeholder.com/150', 'description' => 'Healthcare tailored for children and infants.'],
            ['name' => 'Dermatology', 'image' => 'https://via.placeholder.com/150', 'description' => 'Skin, hair, and nail treatment solutions.'],
        ];
    @endphp

    <!-- Chatbot Section -->
    <div class="col-12">
        <div class="card h-100 text-center">
            <div class="card-body">
                <h5 class="card-title">How do you feel?</h5>
                <p class="card-text">Let our AI chatbot assist you in selecting the best clinic for your condition.</p>
                <button class="btn btn-primary" onclick="openChatbot()">Start Chat</button>
            </div>
        </div>
    </div>

    <!-- Clinics List -->
    @foreach ($clinics as $clinic)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <img class="card-img-top" src="{{ $clinic['image'] }}" alt="{{ $clinic['name'] }} Clinic" />
                <div class="card-body">
                    <h5 class="card-title">{{ $clinic['name'] }}</h5>
                    <p class="card-text">{{ $clinic['description'] }}</p>
                    <a href="{{ route('appointments.create', ['clinic' => $clinic['name']]) }}" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Chatbot Modal -->
<div id="chatbotModal" class="chatbot-modal">
    <div class="chatbot-content">
        <span class="close-btn" onclick="closeChatbot()">&times;</span>
        <h5>AI Chatbot</h5>
        <div id="chatbotMessages"></div>
        <input type="text" id="chatInput" placeholder="Describe your symptoms..." onkeypress="sendMessage(event)">
    </div>
</div>

<style>
    .chatbot-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        padding: 15px;
        z-index: 1000;
    }
    .chatbot-content {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .close-btn {
        align-self: flex-end;
        cursor: pointer;
        font-size: 20px;
    }
    #chatbotMessages {
        height: 150px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
    }
    #chatInput {
        width: 100%;
        padding: 8px;
    }
</style>

<script>
    function openChatbot() {
        document.getElementById("chatbotModal").style.display = "block";
    }

    function closeChatbot() {
        document.getElementById("chatbotModal").style.display = "none";
    }

    function sendMessage(event) {
        if (event.key === "Enter") {
            let input = document.getElementById("chatInput").value.trim();
            if (input !== "") {
                let chatbox = document.getElementById("chatbotMessages");
                chatbox.innerHTML += "<p><strong>You:</strong> " + input + "</p>";

                fetch('/api/chatbot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: input })
                })
                .then(response => response.json())
                .then(data => {
                    chatbox.innerHTML += "<p><strong>AI:</strong> " + data.response + "</p>";
                    document.getElementById("chatInput").value = "";
                    chatbox.scrollTop = chatbox.scrollHeight;
                });
            }
        }
    }
</script>
@endsection
