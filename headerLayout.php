
<body>
    <header>
        <menu>
            <menuitem>
                <h1>To Do list</h1>
            </menuitem>
            <menuitem>
                <p><a href="addEditGoal.php">Dodaj Zadanie</a></p>
            </menuitem>
            <menuitem>
                <form method="post" action="index.php">
                    <p>Sortuj według:</p>
                    <select class="form-control" name="sortBy">
                        <option value="dataZakonczenia">
                            Data Zakończenia
                        </option>
                        <option value="dataWpisu">
                            Data Wpisu
                        </option>
                        <option value="status">
                            Status
                        </option>
                    </select>
                    <input type="submit" value="Sortuj">
                </form>
            </menuitem>
            <menuitem>
                <a href="logout.php">Wyloguj się</a>
            </menuitem>

        </menu>
    </header>