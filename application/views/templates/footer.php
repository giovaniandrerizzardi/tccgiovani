<?php
if (isset($footerHide) && $footerHide == true) {
    
} else {
?>
    <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation" style="border-bottom: 4px solid #000090;">
        <div class="container">
            <footer>
                <center><p style="padding-top: 15px;">&copy; Interface Web - <?php echo date("Y"); ?></p></center>
            </footer>
        </div>
    </nav>
<?php
}
?>
</div>
</body>
</html>