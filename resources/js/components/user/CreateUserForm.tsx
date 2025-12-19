import React from 'react';
import { useForm } from '@inertiajs/react';

type Props = {
    open: boolean;
    onClose: () => void;
};

export default function CreateUserModal({ open, onClose }: Props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
        phone: '',
        role_id: ''
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
            <div className="bg-white dark:bg-gray-900 w-full max-w-md rounded-lg shadow-lg p-6">
                <h2 className="text-lg font-semibold mb-4">
                    Create user
                </h2>

                <form onSubmit={submit} className="space-y-4">
                    <div>
                        <label className="block text-sm mb-1">
                            First name
                        </label>
                        <input
                            className="w-full rounded border px-3 py-2"
                            value={data.first_name}
                            onChange={e => setData('first_name', e.target.value)}
                        />
                        {errors.first_name && (
                            <p className="text-sm text-red-600">
                                {errors.first_name}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm mb-1">
                            Last name
                        </label>
                        <input
                            className="w-full rounded border px-3 py-2"
                            value={data.last_name}
                            onChange={e => setData('last_name', e.target.value)}
                        />
                        {errors.last_name && (
                            <p className="text-sm text-red-600">
                                {errors.last_name}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm mb-1">
                            Email
                        </label>
                        <input
                            type="email"
                            className="w-full rounded border px-3 py-2"
                            value={data.email}
                            onChange={e => setData('email', e.target.value)}
                        />
                        {errors.email && (
                            <p className="text-sm text-red-600">
                                {errors.email}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm mb-1">
                            Password
                        </label>
                        <input
                            type="password"
                            className="w-full rounded border px-3 py-2"
                            value={data.password}
                            onChange={e => setData('password', e.target.value)}
                        />
                        {errors.password && (
                            <p className="text-sm text-red-600">
                                {errors.password}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm mb-1">
                            Password Confirmation
                        </label>
                        <input
                            type="password"
                            className="w-full rounded border px-3 py-2"
                            value={data.password_confirmation}
                            onChange={e => setData('password_confirmation', e.target.value)}
                        />
                        {errors.password_confirmation && (
                            <p className="text-sm text-red-600">
                                {errors.password_confirmation}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm mb-1">
                            Phone
                        </label>
                        <input
                            type="text"
                            className="w-full rounded border px-3 py-2"
                            value={data.phone}
                            onChange={e => setData('phone', e.target.value)}
                        />
                        {errors.phone && (
                            <p className="text-sm text-red-600">
                                {errors.phone}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm mb-1">
                            Role Id
                        </label>
                        <input
                            type="text"
                            className="w-full rounded border px-3 py-2"
                            value={data.role_id}
                            onChange={e => setData('role_id', e.target.value)}
                        />
                        {errors.role_id && (
                            <p className="text-sm text-red-600">
                                {errors.role_id}
                            </p>
                        )}
                    </div>

                    <div className="flex justify-end gap-2 pt-4">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2 text-sm border rounded"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            disabled={processing}
                            className="px-4 py-2 text-sm bg-blue-600 text-white rounded"
                        >
                            {processing ? 'Saving…' : 'Create'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
