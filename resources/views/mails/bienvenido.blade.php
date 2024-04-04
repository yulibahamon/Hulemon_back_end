<center>
    <table style="font-family: sans-serif; width:610px; max-width:60vw; min-width:596px; border: 2px solid;  border-color: #000; margin: 0 auto; border-collapse: collapse">
        
        <tr>
            <td>
                <center>
                    <img src="{{asset('/imagenes/headerQaddro.png')}}" alt="" class="text-center" style="width: 100%">
                </center>
                <br>
                <br>
            </td>
        </tr>
        <tr>
            <td bgcolor="#e3e0e5" style="color: #4e58cc" style="vertical-align: middle">
                <center>
                    <br>
                    <h1><b>Bienvenido a Qaddro.com</b></h1>
                    <br>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <br>
                    <h2 style="color: #a860ad;"><b>¡Hola!</b></h2>
                    <h2 style="color: #00;">{{$info->name}}</h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <td>
                <center>
                    <h2 style="color: #4e58cc"><b>RECUERDA QUE TU USUARIO ES:</b></h2>
                    <h2>Correo electronico: {{$info->email}}</h2>
                    <h2 style="color: #4e58cc"><b>Tu Contraseña es:</b></h2>
                    <h2>No° movil: ******{{substr($info->phone_call, -4)}}</h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <td>
                <center>
                    @if (!empty($userClientId))
                        <a href="https://tarjeta.digital.interwapp.com/user/{{$userClientId}}">
                            <img src="{{ asset('/imagenes/Regresa_tarjeta_virtual.png') }}" alt="" style="width: 70rem">
                        </a>
                    @else
                        <a href="https://tarjeta.digital.interwapp.com/contactos">
                            <img src="{{ asset('/imagenes/Regresa_tarjeta_virtual.png') }}" alt="" style="width: 70rem">
                        </a>
                    @endif
                </center>
            </td>
        </tr>

        <tr>
            <td>
                <center>
                    <h2 style="font-size: 0.7rem color: #74797b">©2023 Todos los derechos reservados by <a href="https://interwapp.com/" style="color: #4ba3c7"><u>InterWapp</u></a></h2>
                </center>
            </td>
        </tr>
    </table>
</center>
