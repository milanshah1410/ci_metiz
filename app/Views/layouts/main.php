<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Employee Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php if (session()->get('logged_in')): ?>
        <!-- Sidebar and Header for logged in users -->
        <div class="flex flex-col md:flex-row min-h-screen w-full">
            <!-- Sidebar -->
            <div class="bg-indigo-800 text-white w-full md:w-64 flex-shrink-0 md:min-h-screen">
                <div class="p-4 font-bold text-xl">
                    <a href="<?= base_url('/dashboard') ?>" class="flex items-center">
                        <i class="fas fa-building mr-2"></i>
                        <span>EMS</span>
                    </a>
                </div>
                <nav class="p-2">
                    <ul>
                        <li class="mb-1">
                            <a href="<?= base_url('/dashboard') ?>" class="block py-2 px-4 rounded hover:bg-indigo-700 <?= uri_string() == 'dashboard' ? 'bg-indigo-900' : '' ?>">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="<?= base_url('/leave') ?>" class="block py-2 px-4 rounded hover:bg-indigo-700 <?= uri_string() == 'dashboard/profile' ? 'bg-indigo-900' : '' ?>">
                                <i class="fas fa-calendar-alt mr-2"></i> Leave Management
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="<?= base_url('/dashboard/profile') ?>" class="block py-2 px-4 rounded hover:bg-indigo-700 <?= uri_string() == 'dashboard/profile' ? 'bg-indigo-900' : '' ?>">
                                <i class="fas fa-user mr-2"></i> My Profile
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="<?= base_url('/dashboard/change-password') ?>" class="block py-2 px-4 rounded hover:bg-indigo-700 <?= uri_string() == 'dashboard/change-password' ? 'bg-indigo-900' : '' ?>">
                                <i class="fas fa-key mr-2"></i> Change Password
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="<?= base_url('/auth/logout') ?>" class="block py-2 px-4 rounded hover:bg-indigo-700">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white shadow">
                    <div class="mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <h1 class="text-lg font-semibold text-gray-800"><?= isset($page_title) ? $page_title : 'Dashboard' ?></h1>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 mr-2"><?= session()->get('employee_name') ?></span>
                            <div class="relative group">
                                <button class="rounded-full bg-gray-200 p-1 w-8 h-8 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                                    <a href="<?= base_url('/dashboard/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                    <a href="<?= base_url('/auth/logout') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto p-4">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p><?= session()->getFlashdata('success') ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p><?= session()->getFlashdata('error') ?></p>
                        </div>
                    <?php endif; ?>

                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    <?php else: ?>
        <!-- Simple layout for non-logged in users -->
        <div class="flex flex-col min-h-screen">
            <header class="bg-indigo-800 text-white shadow">
                <div class="container mx-auto px-4 py-4">
                    <h1 class="text-lg font-bold">Employee Management System</h1>
                </div>
            </header>

            <main class="flex-1 container mx-auto px-4 py-8">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('success') ?></p>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('error') ?></p>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    <?php endif; ?>
</body>

</html>