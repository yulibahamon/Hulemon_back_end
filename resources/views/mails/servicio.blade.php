<style>
    @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@400&display=swap');
</style>

<center>
    <table style="font-family: 'Comfortaa', cursive;">
        <tr>
            <img src="{{asset('imagenes/header_correo.png')}}" alt="" style="width: 100%">
        </tr>
        <tr>
            <br><br><br>
        </tr>
        <tr>
            <td>
                <center>
                    <h2><b>¡HOLA!</b></h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">{{$servicio->usuario->name}}</h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">Cel: {{$servicio->usuario->phone_call}}</h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">Mail: {{$servicio->usuario->email}}</h2>
                </center>
            </td>
        </tr>

        <tr>
            <td>
                <br>
                <br>
                <br>
                <center>
                    <h2><b>TU NÚMERO DE SERVICIO ES:</b></h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">#{{$servicio->id}}</h2>
                </center>
            </td>
        </tr>

        <tr>
            <td>
                <br>
                <br>
                <br>
                <center>
                    <h2><b>Nuestros ejecutivos estarán atentos para agendar una cita contigo</b></h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">Fecha: 00/00/0000</h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">Hora: 00:00</h2>
                </center>
            </td>
        </tr>

        <tr>
            <td>
                <br>
                <br>
                <br>
                <center>
                    <h2><b>TU USUARIO ES:</b></h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">Usuario mail: {{$servicio->usuario->email}}</h2>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <h2 style="color: gray;">Password: {{$servicio->usuario->phone_call}}</h2>
                </center>
            </td>
        </tr>

        <tr>
            <td>
                <br>
                <br>
                <br>
                <center>
                    <h3><a href="https://raddiar.interwapp.com/" style="color: black"><u>www.raddiar.com</u></a></h3>
                </center>
            </td>
        </tr>

        <tr>
            <td>
                <br>
                <br>
                <br>
                <center>
                    <h2>2023 Todos los derechos reservados by <a href="https://interwapp.com/" style="color: black"><u>InterWapp</u></a></h2>
                </center>
            </td>
        </tr>
    </table>
</center>
