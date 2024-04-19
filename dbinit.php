<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('utils/db_conn.php');
        $pdo = $db->pdo;
        
    $pdo->query("create table if not exists users (
        id int auto_increment,
        name varchar(50),
        password varchar(100),
        email varchar(50),
        primary key (id)
    );");

    $passwordplant = password_hash('phpecommerce', PASSWORD_DEFAULT);

    $query = "
        INSERT INTO users (name, password, email) VALUES
        ('Group7_Plant', '$passwordplant', 'ecommerce@plant.in')
    ";

    $pdo->query($query);
    $pdo->query("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price INT,
        imgUrl VARCHAR(255)
    );");
    
    $query = "INSERT INTO products (name, description, price, imgUrl) VALUES 
        ('Joey Improved Ptilotus', 'This eye-catching, unusual plant is much tougher than the soft blooms make it seem, with excellent heat and drought tolerance.', 59, 'images/ptilotus.jpeg'),
        ('Sallyfun Deep Ocean Salvia', 'Abundant spikes of stunning violet-blue flowers rise above the aromatic foliage all summer long.', 80, 'images/salvia.jpg'),
        ('Angelic Sweets Marguerite Daisy', 'This early bloomer is prized for its standout color and nonstop flowers.', 170, 'images/red.jpg'),
        ('Black & Bloom Salvia', 'Stalks of dark blue and blue flowers emerge from striking black stems amidst green foliage.', 47, 'images/blackSalvia.jpeg'),
        ('Sallyfun Snow White Salvia', 'Abundant spikes of crisp white flowers rise above the aromatic foliage all summer long. ', 49, 'images/whiteSalvia.jpeg'),
        ('Tropicanna Canna', 'Exotic foliage adds interest, with emerging bright burgundy leaves maturing with stripes of red, pink, yellow, and green.', 109, 'images/canna.jpeg'),
        ('Goldflame Honeysuckle', 'An excellent vine to use as a cover for trellis, arbor and fencing. Also works well when pruned to form a dense shrub-like shape.', 89, 'images/honeysuckle.jpg'),
        ('Jackman Superba Clematis', 'The most popular of the clematis vines. Showy, deep violet-purple flowers are slightly broader than those of C.', 75, 'images/clematis.jpeg'),
        ('Evolution Colorific Coneflower', 'An enchanting green cone - as green as the leaves - at the center of every bloom, framed by dense petals in a lovely palette of pink hues.', 199, 'images/coneflower.jpeg'),
        ('Seaside Serenade Newport Hydrangea', 'A showy rebloomer with a profusion of full mophead flower clusters that mature to a deep pink on very sturdy stems.', 159, 'images/hydrangea.jpg'),
        ('Blue Skies Lilac', 'One of the best lilacs for warm winter areas. Produces spectacular clusters of light lavender-blue flowers without winter chilling!', 85, 'images/lilac.jpg'),
        ('Blue Enchantress Hydrangea', 'Striking ruby-black stems support big mophead flowers on this exquisite reblooming hydrangea.', 64, 'images/BH.jpeg'),
        ('Candy Apple Hydrangea', 'A new, irresistible variety with the same show-stopping lime green flower clusters as Limelight, but a more compact form.', 149, 'images/WH.jpeg'),
        ('Strawberry Shake Hydrangea', 'A gorgeous new panicle hydrangea, on a much more compact form.', 97, 'images/SH.jpeg')";


    $pdo->query($query);
    $pdo->query("
    CREATE TABLE if not exists cart (id INT AUTO_INCREMENT PRIMARY KEY,
            userid INT NOT NULL,
            productid INT NOT NULL,
            FOREIGN KEY (userid) REFERENCES users(id),
            FOREIGN KEY (productid) REFERENCES products(id));");
        echo " Successful Initialized.";
        exit;
    }
?>

<html>
    <body>
        <form method="post">
            <button type="submit">Database Initialized</button>
        </form>
    </body>
</html>