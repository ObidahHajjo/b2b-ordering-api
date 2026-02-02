import { useForm } from '@inertiajs/react';
import React from 'react';
import { Role } from '@/models/Role';

type Props = {
    open: boolean;
    onClose: () => void;
    roles: Role[];
    stores: Store[];
};

type Store = {
    id: string;
    name: string;
}
export default function CreateUserModal({ open, onClose, roles, stores }: Props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
        phone: '',
        role_id: '',
        store_id: '',
    });

    if (!open) return null;

    function submit(e: React.FormEvent) {
        e.preventDefault();

        post('/users', {
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    }

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div className="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900">
                <h2 className="mb-4 text-lg font-semibold">Create user</h2>

                <form onSubmit={submit} className="space-y-4">
                    <div>
                        <label className="mb-1 block text-sm">First name</label>
                        <input
                            className="w-full rounded border px-3 py-2"
                            value={data.first_name}
                            onChange={(e) =>
                                setData('first_name', e.target.value)
                            }
                        />
                        {errors.first_name && (
                            <p className="text-sm text-red-600">
                                {errors.first_name}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="mb-1 block text-sm">Last name</label>
                        <input
                            className="w-full rounded border px-3 py-2"
                            value={data.last_name}
                            onChange={(e) =>
                                setData('last_name', e.target.value)
                            }
                        />
                        {errors.last_name && (
                            <p className="text-sm text-red-600">
                                {errors.last_name}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="mb-1 block text-sm">Email</label>
                        <input
                            type="email"
                            className="w-full rounded border px-3 py-2"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                        />
                        {errors.email && (
                            <p className="text-sm text-red-600">
                                {errors.email}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="mb-1 block text-sm">Password</label>
                        <input
                            type="password"
                            className="w-full rounded border px-3 py-2"
                            value={data.password}
                            onChange={(e) =>
                                setData('password', e.target.value)
                            }
                        />
                        {errors.password && (
                            <p className="text-sm text-red-600">
                                {errors.password}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="mb-1 block text-sm">
                            Password Confirmation
                        </label>
                        <input
                            type="password"
                            className="w-full rounded border px-3 py-2"
                            value={data.password_confirmation}
                            onChange={(e) =>
                                setData('password_confirmation', e.target.value)
                            }
                        />
                        {errors.password_confirmation && (
                            <p className="text-sm text-red-600">
                                {errors.password_confirmation}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="mb-1 block text-sm">Phone</label>
                        <input
                            type="text"
                            className="w-full rounded border px-3 py-2"
                            value={data.phone}
                            onChange={(e) => setData('phone', e.target.value)}
                        />
                        {errors.phone && (
                            <p className="text-sm text-red-600">
                                {errors.phone}
                            </p>
                        )}
                    </div>

                    <div className="relative">
                        <label className="block text-sm mb-1 text-gray-700 dark:text-gray-300">
                            Role
                        </label>

                        <select
                            className="
            w-full
            appearance-none
            rounded
            border
            border-gray-300
            bg-white
            text-gray-900
            px-3
            py-2
            pr-10
            focus:outline-none
            focus:ring-2
            focus:ring-blue-500
            dark:border-gray-600
            dark:bg-gray-800
            dark:text-gray-100
            dark:focus:ring-blue-400
        "
                            value={data.role_id}
                            onChange={e => setData('role_id', e.target.value)}
                        >
                            <option value="">Select a role</option>
                            {roles.map(role => (
                                <option key={role.id} value={role.id}>
                                    {role.name}
                                </option>
                            ))}
                        </select>

                        {/* Custom arrow */}
                        <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                            <svg
                                className="w-4 h-4 text-gray-700 dark:text-gray-300"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </div>

                        {errors.role_id && (
                            <p className="text-sm text-red-600 dark:text-red-400 mt-1">
                                {errors.role_id}
                            </p>
                        )}
                    </div>

                    <div className="relative">
                        <label className="block text-sm mb-1 text-gray-700 dark:text-gray-300">
                            Role
                        </label>

                        <select
                            className="
            w-full
            appearance-none
            rounded
            border
            border-gray-300
            bg-white
            text-gray-900
            px-3
            py-2
            pr-10
            focus:outline-none
            focus:ring-2
            focus:ring-blue-500
            dark:border-gray-600
            dark:bg-gray-800
            dark:text-gray-100
            dark:focus:ring-blue-400
        "
                            value={data.store_id}
                            onChange={e => setData('store_id', e.target.value)}
                        >
                            <option value="">Select a store</option>
                            {stores.map(store => (
                                <option key={store.id} value={store.id}>
                                    {store.name}
                                </option>
                            ))}
                        </select>

                        {/* Custom arrow */}
                        <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                            <svg
                                className="w-4 h-4 text-gray-700 dark:text-gray-300"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </div>

                        {errors.role_id && (
                            <p className="text-sm text-red-600 dark:text-red-400 mt-1">
                                {errors.role_id}
                            </p>
                        )}
                    </div>

                    <div className="flex justify-end gap-2 pt-4">
                        <button
                            type="button"
                            onClick={onClose}
                            className="rounded border px-4 py-2 text-sm"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            disabled={processing}
                            className="rounded bg-blue-600 px-4 py-2 text-sm text-white"
                        >
                            {processing ? 'Saving…' : 'Create'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
