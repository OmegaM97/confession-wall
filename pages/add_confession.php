<div class="add-confession-wrapper">
    <div class="add-confession-container">
        <a href="index.php?page=confessions" class="back-btn">← Back to Confessions</a>
        
        <section class="confession-form-section">
            <h1>Share Your Confession</h1>
            <p>Express yourself freely. Your story matters. Everything stays anonymous.</p>
            
            <form method="post" action="actions/add_confession.php" class="confession-form">
                <div class="form-group">
                    <label for="content">What's on your mind?</label>
                    <textarea id="content" name="content" placeholder="Share your thoughts, secrets, or feelings here. Be honest, be yourself, stay anonymous." rows="8" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Post Confession</button>
                    <a href="index.php?page=confessions" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </section>

        <div class="form-sidebar">
            <div class="tip-card">
                <h3>💡 Tips</h3>
                <ul>
                    <li>Be authentic</li>
                    <li>Keep it respectful</li>
                    <li>Share what matters</li>
                    <li>You stay anonymous</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.add-confession-wrapper {
  padding: 2rem 20px;
  max-width: 900px;
  margin: 2rem auto;
}

.add-confession-container {
  display: grid;
  grid-template-columns: 1fr 250px;
  gap: 2rem;
}

.back-btn {
  display: inline-block;
  color: var(--sky-blue);
  text-decoration: none;
  font-weight: 600;
  margin-bottom: 1.5rem;
  grid-column: 1 / -1;
  transition: all 0.3s ease;
}

.back-btn:hover {
  color: var(--dark-text);
  transform: translateX(-5px);
}

.confession-form-section {
  background: var(--white);
  border: 1px solid rgba(56, 189, 248, 0.1);
  border-radius: 15px;
  padding: 2.5rem;
  box-shadow: 0 5px 20px rgba(56, 189, 248, 0.08);
}

.confession-form-section h1 {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.confession-form-section > p {
  color: var(--soft-gray);
  margin-bottom: 2rem;
}

.confession-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.form-group label {
  font-weight: 600;
  color: var(--dark-text);
}

.form-group textarea {
  padding: 1.25rem;
  border: 1px solid rgba(56, 189, 248, 0.2);
  border-radius: 10px;
  font-family: inherit;
  font-size: 1rem;
  resize: vertical;
  color: var(--dark-text);
  transition: all 0.3s ease;
}

.form-group textarea::placeholder {
  color: var(--soft-gray);
}

.form-group textarea:focus {
  outline: none;
  border-color: var(--sky-blue);
  box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
}

.form-actions {
  display: flex;
  gap: 1rem;
}

.btn-submit {
  background: var(--gradient);
  color: var(--white);
  padding: 0.75rem 2rem;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 1rem;
  flex: 1;
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(56, 189, 248, 0.3);
}

.btn-cancel {
  padding: 0.75rem 2rem;
  border: 1px solid rgba(56, 189, 248, 0.2);
  border-radius: 10px;
  color: var(--sky-blue);
  text-decoration: none;
  text-align: center;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-cancel:hover {
  background: rgba(56, 189, 248, 0.05);
  border-color: var(--sky-blue);
}

.form-sidebar {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.tip-card {
  background: var(--white);
  border: 1px solid rgba(56, 189, 248, 0.1);
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 5px 20px rgba(56, 189, 248, 0.08);
}

.tip-card h3 {
  margin-bottom: 1rem;
  font-size: 1rem;
}

.tip-card ul {
  list-style: none;
  padding: 0;
}

.tip-card li {
  padding: 0.5rem 0;
  color: var(--dark-text);
  border: none;
  background: none;
  box-shadow: none;
  margin: 0;
}

@media (max-width: 768px) {
  .add-confession-container {
    grid-template-columns: 1fr;
  }

  .confession-form-section {
    padding: 1.5rem;
  }
}

@media (max-width: 480px) {
  .add-confession-wrapper {
    padding: 1rem 15px;
    margin: 1rem auto;
  }

  .confession-form-section h1 {
    font-size: 1.5rem;
  }

  .form-actions {
    flex-direction: column;
  }

  .btn-submit,
  .btn-cancel {
    width: 100%;
  }
}
</style>
