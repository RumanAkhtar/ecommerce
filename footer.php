<footer>
    <div class="footer-content">
        <p>&copy; <?php echo date('Y'); ?> Our Clothing Store. All rights reserved.</p>
        <!-- Optional footer navigation -->
       
    </div>
</footer>

<style>
    footer {
        background-color: #e94e77;
        color: #fff;
        display: flex;
        justify-content: space-between;
        padding: 5px;
        text-align: center;
        margin-top: 100px; /* Add margin from top */
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-nav ul {
        list-style: none;
        padding: 0;
        margin: 5px 0 0; /* Add top margin to separate from the footer content */
        display: flex; /* Use flexbox for horizontal alignment */
        justify-content: space-between; /* Center align the items */
    }

    .footer-nav ul li {
        margin: 0 10px; /* Space between items */
    }

    .footer-nav ul li a {
        color: red;
        text-decoration: none;
    }

    .footer-nav ul li a:hover {
        text-decoration: underline;
    }
</style>
