<body>
    {{ __('Name') }}: {{ $contact->getName() }} <br>
    {{ __('Email') }}: {{ $contact->getEmail() }} <br>
    {{ __('Phone') }}: {{ $contact->getPhone() }} <br>
    {{ __('Message') }}: <br>
    <br>
    {{ $contact->getMessage() }}
</body>