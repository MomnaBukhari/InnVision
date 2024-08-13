@extends('mainlayout')

@section('title') Services @endsection

@section('section1')
<style>
    /* Enhanced Services Page Styles */
    .services-section {
        padding: 8% 2%;
        background-color: #800020;
        color: #fff;
        /* border-radius: 15px; */
        text-align: center;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        margin-bottom: 30px;
    }

    .services-section h1 {
        font-size: 3.5em;
        margin-bottom: 20px;
        letter-spacing: 2px;
    }

    .services-section p {
        font-size: 1.5em;
        font-weight: 300;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .services-list {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-top: 50px;
        padding: 2% 5%;
    }

    .service-item {
        width: 30%;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 4%;

    }

    .service-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    }

    .service-item h3 {
        font-size: 1.8em;
        color: #800020;
        margin-bottom: 15px;
    }

    .service-item p {
        font-size: 1.2em;
        line-height: 1.6;
        color: #555;
    }
</style>

<div class="services-section">
    <h1>Our Services</h1>
    <p>Invision offers a range of services tailored to meet the needs of both hotel owners and customers. Explore our offerings designed to enhance your experience.</p>
</div>

<div class="services-list">
    <div class="service-item">
        <h3>Hotel Registration</h3>
        <p>Seamlessly register your hotel on our platform. Manage sub-branches, rooms, and services with ease, all in one place.</p>
    </div>

    <div class="service-item">
        <h3>Room Management</h3>
        <p>Organize and control all your room details, from availability to pricing, ensuring your customers have the best experience.</p>
    </div>

    <div class="service-item">
        <h3>Customer Booking</h3>
        <p>Allow customers to easily search, select, and book rooms at your hotel. Our intuitive interface makes the booking process effortless.</p>
    </div>

    <div class="service-item">
        <h3>Payment Processing</h3>
        <p>Securely process payments through multiple payment gateways. Ensure transactions are smooth and secure for all parties involved.</p>
    </div>

    <div class="service-item">
        <h3>Analytics & Reporting</h3>
        <p>Gain insights into your hotel's performance with our comprehensive analytics and reporting tools, designed to help you grow your business.</p>
    </div>

    <div class="service-item">
        <h3>Customer Support</h3>
        <p>We offer 24/7 customer support to ensure your experience on Invision is always positive and hassle-free.</p>
    </div>
</div>
@endsection

@section('pusherscript')
@endsection
