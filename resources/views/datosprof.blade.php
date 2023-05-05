    <!-- Main -->
    <div class="main">
        <h2>Identidad</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <table>
                    <tbody>
                        <tr>
                            <td>Nombre</td>
                            <td>:</td>
                            <td>Gerard</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>profesortest@gmail.com</td>
                        </tr>
                        <tr>
                            <td>Dirección</td>
                            <td>:</td>
                            <td>Hospitalet, Barcelona</td>
                        </tr>
                    </tbody>
                </table>
                    <form action="{{ route('passalumno.panel') }}" method="POST">
                        @csrf
                    
                        <div>
                            <label for="newpass">Nueva contraseña</label>
                            <input type="password" id="newpass" name="newpass" required>
                        </div>
                    
                        <button type="submit">Cambiar contraseña</button>
                    </form>
            </div>
        </div>