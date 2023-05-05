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
                            <td>Edgar</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>alumnotest@gmail.com</td>
                        </tr>
                        <tr>
                            <td>Dirección</td>
                            <td>:</td>
                            <td>Hospitalet, Barcelona</td>
                        </tr>
                        <tr>
                            <td>Curso</td>
                            <td>:</td>
                            <td>DAW 2</td>
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