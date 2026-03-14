<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Spectacles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        yellow: {
                            400: '#bbf7d0',
                            500: '#86efac',
                            600: '#4ade80',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">Contact Us</h1>
        
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <form class="space-y-6">
                    <div>
                        <label class="block text-gray-700 mb-2">Name</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" placeholder="Your Name">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" placeholder="your@email.com">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 mb-2">Subject</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" placeholder="Subject">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 mb-2">Message</label>
                        <textarea rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" placeholder="Your message..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-lg font-medium hover:bg-yellow-600 transition">
                        Send Message
                    </button>
                </form>
                
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <div>
                            <i class="fas fa-phone-alt text-yellow-500 text-2xl mb-2"></i>
                            <p class="text-gray-600">+1 234 567 890</p>
                        </div>
                        <div>
                            <i class="fas fa-envelope text-yellow-500 text-2xl mb-2"></i>
                            <p class="text-gray-600">info@spectacles.com</p>
                        </div>
                        <div>
                            <i class="fas fa-map-marker-alt text-yellow-500 text-2xl mb-2"></i>
                            <p class="text-gray-600">123 Eye Street</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
