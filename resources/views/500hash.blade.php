@extends('app.layout')

@section('title', '500 Hash')

@section('content')
    <h2>500 hash</h2>
    <p class="large-description">Enter a string below to retrieve a letter</p>
    <input class="form-control" placeholder="Hash" id="hash-box" /><br>
    <button class="btn btn-primary" id="get-button"><span class="typcn typcn-location-arrow"></span> Submit</button>
    <h3>how to play</h3>
    <p class="how-to-play">
        <b>1.</b> You will receive a unique string of letters (encrypted string) upon check-in.<br>
        <b>2.</b> Enter your encrypted string on this page to retrieve a letter.<br>
        <b>3.</b> Talk to other hackers, obtain their string, and convert them to letters.<br>
        <b>4.</b> Try to figure out the secret phrase 😊!<br><br>
        <span class="text-muted">It is possible to get duplicate letters! Therefore, talk to as many hackers as possible.</span>
    </p>
@endsection

@section('script')

    <script>
        $("#get-button").click(function(){
            axios.get("api/hashletter/" + $("#hash-box").val()).then(function(data){
                alert("The letter is " + data.data);
                window.location.reload();
            }).catch(function(e){
                console.log(e);
                alert("Hash you entered is not valid. :(");
            })
        })
    </script>
@endsection