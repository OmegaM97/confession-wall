<div class="about-wrapper">
    <div class="about-container">
        <a href="index.php?page=home" class="back-btn">← Back to Home</a>
        
        <section class="about-section">
            <h1>About Confession Wall</h1>
            
            <div class="about-card">
                <h2>Our Mission</h2>
                <p>Confession Wall is a safe, anonymous platform where you can share your thoughts and feelings without fear of judgment. We believe everyone deserves a voice, and sometimes that voice is strongest when it remains anonymous.</p>
            </div>

            <div class="about-card">
                <h2>Why Anonymity Matters</h2>
                <p>Anonymity creates a safe space for honest expression. Without the weight of identity, people can share their true thoughts, confess their real struggles, and connect with others who understand them. It's liberating, it's real, and it's what makes Confession Wall unique.</p>
            </div>

            <div class="about-card">
                <h2>Our Values</h2>
                <ul class="values-list">
                    <li><strong>Privacy First</strong> - Your identity is safe with us</li>
                    <li><strong>Community Focused</strong> - Support, not judgment</li>
                    <li><strong>Authenticity</strong> - Real stories, real emotions</li>
                    <li><strong>Safety</strong> - Zero tolerance for hate or harm</li>
                    <li><strong>Modern & Clean</strong> - Beautiful design that respects your privacy</li>
                </ul>
            </div>

            <div class="about-card">
                <h2>Community Guidelines</h2>
                <p>We maintain a respectful community by asking members to:</p>
                <ul class="guidelines-list">
                    <li>Be kind and respectful to all members</li>
                    <li>Avoid hate speech, discrimination, or violence</li>
                    <li>Respect others' stories and experiences</li>
                    <li>Keep the platform spam-free</li>
                    <li>Support and encourage others</li>
                </ul>
            </div>

            <div class="cta-section">
                <h2>Ready to Share Your Story?</h2>
                <a href="index.php?page=add_confession" class="btn btn-primary">Post Your Confession</a>
            </div>
        </section>
    </div>
</div>

<style>
.about-wrapper {
  padding: 2rem 20px;
  max-width: 800px;
  margin: 2rem auto;
}

.about-container {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.about-section {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.about-section h1 {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
}

.about-card {
  background: var(--white);
  border: 1px solid rgba(56, 189, 248, 0.1);
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 5px 20px rgba(56, 189, 248, 0.08);
}

.about-card h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  color: var(--dark-text);
}

.about-card p {
  color: var(--soft-gray);
  line-height: 1.8;
  margin: 0;
}

.values-list,
.guidelines-list {
  list-style: none;
  padding: 0;
  margin-top: 1rem;
}

.values-list li,
.guidelines-list li {
  padding: 0.75rem 0;
  color: var(--dark-text);
  border: none;
  background: none;
  box-shadow: none;
  margin: 0;
}

.cta-section {
  text-align: center;
  padding: 2rem;
  background: var(--gradient);
  border-radius: 15px;
  color: var(--white);
}

.cta-section h2 {
  color: var(--white);
  margin-bottom: 1.5rem;
}

.btn-primary {
  display: inline-block;
  background: var(--white);
  color: var(--sky-blue);
  padding: 0.75rem 2rem;
  border-radius: 25px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

@media (max-width: 480px) {
  .about-wrapper {
    padding: 1rem 15px;
  }

  .about-section h1 {
    font-size: 2rem;
  }

  .about-card {
    padding: 1.5rem;
  }
}
</style>