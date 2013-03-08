<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
        <title><?php echo $nuked['name']; ?>&nbsp;-&nbsp;<?php echo $nuked['slogan']; ?></title>
        <meta charset="utf-8" />
        <link title="style" type="text/css" rel="stylesheet" href="media/css/nkCss.css" />
    </head>
    <body id="nkSiteClose">
        <section>
            <header>
                <hgroup>
                    <img src="images/logo.png" />
                    <h1><?php echo $nuked['name']; ?></h1>
                    <h2><?php echo $nuked['slogan']; ?></h2>
                </hgroup>
            </header>
            <article>
                <p><?php echo SITECLOSED; ?></p>
                <form action="index.php?file=User&amp;nuked_nude=index&amp;op=login" method="post">
                    <div>
                        <label for="pseudo"><?php echo PSEUDO; ?></label>
                            <input id="pseudo" type="text" name="pseudo" size="15" maxlength="180" />
                     </div>
                    <div>
                        <label for="password"><?php echo PASSWORD; ?></label>
                            <input type="password" id="password" name="pass" size="15" maxlength="15" />                        
                            <input type="hidden" class="checkbox" name="rememberMe" value="ok" checked="checked" />
                    </div>
                            <input type="submit" value="<?php echo TOLOG; ?>" />      
                </form>         
            </article>
            <footer>
                <p>
                    <a href="/"><?php echo $nuked['name']; ?></a> &copy; 2001, <?php echo date(Y); ?>&nbsp;|&nbsp;<?php echo POWERED; ?> <a href="http://www.nuked-klan.org">Nuked-Klan</a>
                </p>
            </footer>
        </section>
    </body>
</html>