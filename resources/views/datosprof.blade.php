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
                            <td>{{ auth('profesor')->user()->nombre }}</td>
                        </tr>
                        <tr>
                            <td>Apellido</td>
                            <td>:</td>
                            <td>{{ auth('profesor')->user()->apellido }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ auth('profesor')->user()->email }}</td>
                        </tr>
                    </tbody>
                </table>
                    <form action="{{ route('passprofe.panel') }}" method="POST">
                        @csrf
                    
                        <div>
                            <label for="newpass">Nueva contraseña</label>
                            <input type="password" id="newpass" name="newpass" required>
                        </div>
                    
                        <button type="submit">Cambiar contraseña</button>
                    </form>
            </div>
        </div>