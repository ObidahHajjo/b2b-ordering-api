import { Head, Link } from '@inertiajs/react';
import CreateUserModal from '@/components/user/CreateUserForm';
import { useState } from 'react';

type User = {
    id: string;
    name: string;
    email: string;
};

type Props = {
    users: User[];
};

export default function UsersIndex({ users }: Props) {
    const [open, setOpen] = useState(false);

    return (
        <>
            <Head title="Users" />

            <div className="mx-auto max-w-5xl p-6">
                <h1 className="mb-6 text-2xl font-semibold">Users</h1>
                <div className="overflow-x-auto">
                    <div className="flex justify-between items-center mb-6">
                        <h1 className="text-xl font-semibold">
                            Users
                        </h1>

                        <button
                            onClick={() => setOpen(true)}
                            className="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            + Add user
                        </button>
                    </div>
                    <table className="min-w-full border border-gray-200 dark:border-gray-700">
                        <thead className="bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th className="px-4 py-2 text-left">Name</th>
                                <th className="px-4 py-2 text-left">Email</th>
                                <th className="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            {users.length === 0 && (
                                <tr>
                                    <td
                                        colSpan={3}
                                        className="px-4 py-6 text-center text-gray-500"
                                    >
                                        No users found.
                                    </td>
                                </tr>
                            )}

                            {users.map((user) => (
                                <tr
                                    key={user.email}
                                    className="border-t border-gray-200 dark:border-gray-700"
                                >
                                    <td className="px-4 py-2">
                                        {user.name}
                                    </td>
                                    <td className="px-4 py-2">{user.email}</td>
                                    <td className="px-4 py-2">
                                        <Link
                                            href={`/users/${user.id}`}
                                            className="ml-4 text-blue-600"
                                        >
                                            View
                                        </Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <CreateUserModal
                        open={open}
                        onClose={() => setOpen(false)}
                    />
                </div>
            </div>
        </>
    );
}
