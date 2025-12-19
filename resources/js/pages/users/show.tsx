import React from 'react';
import { Head, Link } from '@inertiajs/react';

type User = {
    id: string; // hashed id
    first_name: string;
    last_name: string;
    email: string;
    created_at: string;
};

type Props = {
    user: User;
};

export default function UserShow({ user }: Props) {
    return (
        <>
            <Head title={`User: ${user.first_name} ${user.last_name}`} />

            <div className="max-w-3xl mx-auto p-6">
                <div className="mb-6">
                    <Link
                        href="/users"
                        className="text-sm text-blue-600 hover:underline"
                    >
                        ← Back to users
                    </Link>
                </div>

                <div className="bg-white dark:bg-gray-900 shadow rounded-lg p-6">
                    <h1 className="text-2xl font-semibold mb-4">
                        User details
                    </h1>

                    <dl className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt className="text-sm text-gray-500">
                                First name
                            </dt>
                            <dd className="text-base font-medium">
                                {user.first_name}
                            </dd>
                        </div>

                        <div>
                            <dt className="text-sm text-gray-500">
                                Last name
                            </dt>
                            <dd className="text-base font-medium">
                                {user.last_name}
                            </dd>
                        </div>

                        <div className="sm:col-span-2">
                            <dt className="text-sm text-gray-500">
                                Email
                            </dt>
                            <dd className="text-base font-medium">
                                {user.email}
                            </dd>
                        </div>

                        <div className="sm:col-span-2">
                            <dt className="text-sm text-gray-500">
                                Created at
                            </dt>
                            <dd className="text-base font-medium">
                                {user.created_at}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </>
    );
}
