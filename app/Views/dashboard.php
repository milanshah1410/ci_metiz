<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-500 text-white p-3 rounded-md">
                <i class="fas fa-user"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Employee ID</h2>
                <p class="text-lg font-semibold text-gray-800"><?= $employee['employee_code'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 text-white p-3 rounded-md">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Email</h2>
                <p class="text-lg font-semibold text-gray-800"><?= $employee['email'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 text-white p-3 rounded-md">
                <i class="fas fa-phone"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Phone</h2>
                <p class="text-lg font-semibold text-gray-800"><?= $employee['phone'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-500 text-white p-3 rounded-md">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Location</h2>
                <p class="text-lg font-semibold text-gray-800"><?= $employee['city'] ?>, <?= $employee['country'] ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Personal Info Card -->
    <div class="bg-white rounded-lg shadow lg:col-span-2">
        <div class="px-4 py-5 sm:px-6 border-b">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Employee personal details</p>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                <div>
                    <dt class="text-gray-500">Full name</dt>
                    <dd class="mt-1 text-gray-900 font-medium"><?= $employee['first_name'] . ' ' . $employee['last_name'] ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">Username</dt>
                    <dd class="mt-1 text-gray-900 font-medium"><?= $employee['username'] ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">Email address</dt>
                    <dd class="mt-1 text-gray-900 font-medium"><?= $employee['email'] ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">Phone number</dt>
                    <dd class="mt-1 text-gray-900 font-medium"><?= $employee['phone'] ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">Address</dt>
                    <dd class="mt-1 text-gray-900"><?= $employee['address'] ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">Location</dt>
                    <dd class="mt-1 text-gray-900"><?= $employee['city'] ?>, <?= $employee['state'] ?>, <?= $employee['country'] ?> - <?= $employee['zip'] ?></dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-5 sm:px-6 border-b">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Quick Links</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Shortcuts to important pages</p>
        </div>
        <div class="p-6">
            <ul class="space-y-3">
                <li>
                    <a href="<?= base_url('/dashboard/profile') ?>" class="flex items-center text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-user-edit mr-2"></i>
                        <span>Edit Profile</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('/leave') ?>" class="flex items-center text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Leave Management</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
