<?php
if (isset($footerHide) && $footerHide == true) {
    
} else {
?>
    <nav class="navbar-fixed-bottom navbar-default" role="navigation" style="border-bottom: 4px solid #000090;">
        <div class="container">
            <footer>
                <center><p style="padding-top: 5px; margin-top: 30px">&copy; Interface Web - <?php echo date("d-m-Y"); ?></p></center>
            </footer>
        </div>
    </nav>
<?php
}
?>
</div>
</body>
</html>