<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ __('locale.Control') }}: {{ $frameworkControlTestAudit->name ?? __('locale.N/A') }}</h4>
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item">
                <strong>{{ __('locale.Description') }}:</strong>
                <p class="description">
                    {{ $frameworkControlTestAudit->FrameworkControl->description ?? __('locale.No description available') }}
                </p>
            </div>
            <div class="info-item">
                <strong>{{ __('locale.Due Date Audit') }}:</strong>
                <span>{{ $dueDate ?? __('locale.N/A') }}</span>
            </div>
            <div class="info-item">
                <strong>{{ __('locale.Auditor') }}:</strong>
                <span>{{ $aduiterResponsible ?? __('locale.N/A') }}</span>
            </div>
            <div class="info-item">
                <strong>{{ __('locale.Assistant') }}:</strong>
                <ul>
                    @forelse ($testAssistants as $assistant)
                        <li>{{ $assistant }}</li>
                    @empty
                        <li>{{ __('locale.N/A') }}</li>
                    @endforelse
                </ul>
            </div>
            <div class="info-item">
                <strong>{{ __('locale.Auditees Collect Evidence') }}:</strong>
                <span>{{ $collectiveEvidence ?? __('locale.N/A') }}</span>
            </div>
        </div>
    </div>
</div>


<style>
.card {
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fdfdfd;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.card-header {
    background-color: #007bff;
    color: #fff;
    padding: 15px;
    font-size: 1.5rem;
    font-weight: 700;
    text-align: center;
    border-bottom: 2px solid #0056b3;
}

.card-body {
    padding: 20px;
}

.card-title {
    margin: 0;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.info-item {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 5px solid #007bff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.info-item strong {
    display: block;
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 5px;
}

.description {
    font-size: 1rem;
    color: #555;
}

.info-item span, .info-item li {
    font-size: 1rem;
    color: #666;
}

.info-item ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.info-item li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 8px;
}

.info-item li:before {
    content: '→';
    position: absolute;
    left: 0;
    color: #007bff;
    font-weight: bold;
}
</style>
