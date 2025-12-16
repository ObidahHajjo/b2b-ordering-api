import { Head, Link } from '@inertiajs/react';

type User = {
    id: string;
    name: string;
    email: string;
};

type Props = {
    users: User[];
};

export default function UsersIndex({ users }: Props) {
    return (
        <>
            <Head title="Users" />

            <div className="mx-auto max-w-5xl p-6">
                <h1 className="mb-6 text-2xl font-semibold">Users</h1>
                <div className="overflow-x-auto">
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
                </div>
            </div>
        </>
    );
}
