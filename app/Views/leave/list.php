<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
    <div class="px-6 py-4 bg-indigo-600 sm:px-8 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-white">Leave Records</h2>
            <p class="text-indigo-200">Your leave history and remaining balance</p>
        </div>
        <a href="<?= base_url('/leave/apply') ?>" class="px-4 py-2 bg-white text-indigo-600 font-medium rounded-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Apply for Leave
        </a>
    </div>

    <?php if (session()->has('success')): ?>
        <div class="m-4 p-4 bg-green-100 rounded-md">
            <p class="text-green-700"><?= session('success') ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="m-4 p-4 bg-red-100 rounded-md">
            <p class="text-red-700"><?= session('error') ?></p>
        </div>
    <?php endif; ?>

    <!-- Leave Balance Summary -->
    <div class="p-6 sm:p-8 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Current Leave Balance</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php if (!empty($leaveBalance)): ?>
                <?php foreach ($leaveBalance as $balance): ?>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700"><?= $balance->leaveType ?></h4>
                        <p class="mt-2 text-2xl font-bold text-indigo-600"><?= $balance->current_balance ?> days</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Leave History Table -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 bg-indigo-600 sm:px-8">
        <h2 class="text-lg font-bold text-white">Leave History</h2>
        <p class="text-indigo-200">List of all your leave applications</p>
    </div>

    <div class="p-6 sm:p-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($leaveRecords)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No leave records found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($leaveRecords as $leave): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $leave['leaveType'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d M Y', strtotime($leave['fromdate'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d M Y', strtotime($leave['todate'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $leave['numberofDays'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $leave['status'] = getStatusLabel($leave['status']); // Default to 'Pending' if status is not set
                                    $statusClass = '';
                                    switch ($leave['status']) {
                                        case 'Pending':
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'Approved':
                                            $statusClass = 'bg-green-100 text-green-800';
                                            break;
                                        case 'Rejected':
                                            $statusClass = 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                    }
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                        <?= $leave['status'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="truncate max-w-xs" title="<?= htmlspecialchars($leave['comment']) ?>">
                                        <?= htmlspecialchars($leave['comment']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d M Y', strtotime($leave['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager)): ?>
            <div class="mt-4">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>