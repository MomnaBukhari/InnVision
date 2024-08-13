@extends('mainlayout')

@section('title') About @endsection

@section('section1')
<style>
    /* Enhanced About Page Styles */
    .about-section {
        padding: 8% 2%;
        background-color: #800020;
        color: #fff;
        /* border-radius: 15px; */
        text-align: center;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        margin-bottom: 30px;
    }

    .about-section h1 {
        font-size: 3.5em;
        margin-bottom: 20px;
        letter-spacing: 2px;
    }

    .about-section p {
        font-size: 1.5em;
        font-weight: 300;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .mission-section, .vision-section, .values-section {
        padding: 60px 20px;
        text-align: center;
        background-color: #ffffff;
        border-radius: 15px;
        max-width: 900px;
        margin: 30px auto;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .mission-section h2, .vision-section h2, .values-section h2 {
        font-size: 2.8em;
        margin-bottom: 20px;
        color: #800020;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .mission-section p, .vision-section p, .values-section p {
        font-size: 1.2em;
        line-height: 1.8;
        color: #555;
    }

    .values-section ul {
        list-style-type: none;
        padding: 0;
    }

    .values-section li {
        font-size: 1.2em;
        color: #666;
        margin-bottom: 15px;
        padding-left: 25px;
        position: relative;
    }

    .values-section li::before {
        content: "\2022";
        color: #800020;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
</style>

<div class="about-section">
    <h1>About Invision</h1>
    <p>Invision is a cutting-edge hotel management and booking platform designed to empower hotel owners and provide customers with an unparalleled booking experience. Our goal is to simplify the hospitality industry through innovation and technology.</p>
</div>

<div class="mission-section">
    <h2>Our Mission</h2>
    <p>Our mission is to revolutionize the way hotels are managed and bookings are made. We strive to deliver a seamless experience for both hotel owners and customers by offering powerful tools and a user-friendly interface.</p>
</div>

<div class="vision-section">
    <h2>Our Vision</h2>
    <p>We envision a world where hotel management and booking are effortless, transparent, and enjoyable for everyone involved. Through Invision, we aim to set new standards in the hospitality industry, enhancing both operational efficiency and customer satisfaction.</p>
</div>

<div class="values-section">
    <h2>Our Core Values</h2>
    <ul>
        <li><strong>Innovation:</strong> Continuously pushing the boundaries to bring new and improved solutions to our users.</li>
        <li><strong>Customer-Centricity:</strong> Placing our users at the heart of everything we do, ensuring a superior experience.</li>
        <li><strong>Integrity:</strong> Upholding the highest ethical standards in all our operations and interactions.</li>
        <li><strong>Excellence:</strong> Striving for perfection in every aspect of our platform and services.</li>
    </ul>
</div>
@endsection

@section('pusherscript')
@endsection
