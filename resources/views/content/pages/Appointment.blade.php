@extends('layouts/layoutMaster')

@section('title', 'Patient Dashboard')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="row mb-12 g-4">
    @php
        $clinics = [
            ['name' => 'Cardiology', 'image' => 'https://www.hawaiipacifichealth.org/media/3922/what-is-a-cardiologist-web.jpg', 'description' => 'Expert heart care and cardiovascular treatments.'],
            ['name' => 'Dentistry', 'image' => 'https://th.bing.com/th/id/OIP.FDv4CjYHYwDIfKollMEGwwHaE8?rs=1&pid=ImgDetMain', 'description' => 'Comprehensive dental services for all ages.'],
            ['name' => 'Neurology', 'image' => 'https://th.bing.com/th/id/OIP.G8GkePvKtmQ87SY1dmisIQHaE7?w=626&h=417&rs=1&pid=ImgDetMain', 'description' => 'Advanced brain and nervous system care.'],
            ['name' => 'Orthopedics', 'image' => 'https://res.cloudinary.com/lowellgeneral/image/upload/c_fill,w_auto,g_faces,q_auto,dpr_auto,f_auto/orthopedic-center1_BFAFBDC0-FC11-11E9-92C400218628D024.jpg', 'description' => 'Bone and joint health specialists.'],
            ['name' => 'Pediatrics', 'image' => 'https://th.bing.com/th/id/R.3ad22fe95e70c998264acaf1d471d668?rik=DohY9CkyOVlH2w&pid=ImgRaw&r=0', 'description' => 'Healthcare tailored for children and infants.'],
            ['name' => 'Dermatology', 'image' => 'https://www.nccpa.net/wp-content/uploads/2022/03/shutterstock_625301408.jpg', 'description' => 'Skin, hair, and nail treatment solutions.'],
            ['name' => 'Oncology ', 'image' => 'https://th.bing.com/th/id/OIP.ltfNltFBGV21XxzgZuDbsgHaE8?w=1000&h=667&rs=1&pid=ImgDetMain', 'description' => 'Focuses on the diagnosis and treatment of cancer.'],
            ['name' => 'Ophthalmology ', 'image' => 'https://th.bing.com/th/id/R.3cb7a106f02a04e3dff40f61ee317329?rik=3HaGAdZB%2bEYJzw&pid=ImgRaw&r=0', 'description' => 'Deals with eye and vision care.'],
            ['name' => 'Endocrinology ', 'image' => 'https://eunamed.com/wp-content/uploads/2021/02/portada-endocrino-scaled.jpg', 'description' => 'Focuses on hormonal and metabolic disorders'],
            ['name' => 'Gastroenterology ', 'image' => 'https://gastroliversc.com.sg/wp-content/uploads/2022/09/gastro-home-page-image-2-3.jpg', 'description' => 'Specializes in digestive system disorders'],
            ['name' => 'Urology ', 'image' => 'https://amarhospital.com/wp-content/uploads/2020/06/urology.jpg', 'description' => 'Deals with the urinary tract and male reproductive system.'],
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
