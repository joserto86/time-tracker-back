<?php

namespace App\Model;

class GlUser implements TimeTrackerModelInterface
{
    private int $id;

    private string $username;

    private string $name;

    private string $state;

    private string $avatarUrl;

    private string $webUrl;

    private \DateTimeInterface $createdAt;

    private string $bio;

    private string $location;

    private string $publicEmail;

    private string $skype;

    private string $linkedin;

    private string $twitter;

    private string $websiteUrl;

    private string $organization;

    private string $jobTitle;

    private ?string $pronouns;

    private bool $bot;

    private ?string $workInformation;

    private int $followers;

    private int $following;

    private string $localTime;

    private \DateTimeInterface $lastSignInAt;

    private \DateTimeInterface $confirmedAt;

    private \DateTimeInterface $lastActivityOn;

    private string $email;

    private int $themeId;

    private int $colorSchemeId;

    private int $projectsLimit;

    private \DateTimeInterface $currentSignInAt;

    private bool $canCreateGroup;

    private bool $canCreateProject;

    private bool $twoFactorEnabled;

    private bool $external;

    private bool $privateProfile;

    private string $commitEmail;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return GlUser
     */
    public function setId(int $id): GlUser
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return GlUser
     */
    public function setUsername(string $username): GlUser
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return GlUser
     */
    public function setName(string $name): GlUser
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return GlUser
     */
    public function setState(string $state): GlUser
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    /**
     * @param string $avatarUrl
     * @return GlUser
     */
    public function setAvatarUrl(string $avatarUrl): GlUser
    {
        $this->avatarUrl = $avatarUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebUrl(): string
    {
        return $this->webUrl;
    }

    /**
     * @param string $webUrl
     * @return GlUser
     */
    public function setWebUrl(string $webUrl): GlUser
    {
        $this->webUrl = $webUrl;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return GlUser
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): GlUser
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     * @return GlUser
     */
    public function setBio(string $bio): GlUser
    {
        $this->bio = $bio;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return GlUser
     */
    public function setLocation(string $location): GlUser
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicEmail(): string
    {
        return $this->publicEmail;
    }

    /**
     * @param string $publicEmail
     * @return GlUser
     */
    public function setPublicEmail(string $publicEmail): GlUser
    {
        $this->publicEmail = $publicEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getSkype(): string
    {
        return $this->skype;
    }

    /**
     * @param string $skype
     * @return GlUser
     */
    public function setSkype(string $skype): GlUser
    {
        $this->skype = $skype;
        return $this;
    }

    /**
     * @return string
     */
    public function getLinkedin(): string
    {
        return $this->linkedin;
    }

    /**
     * @param string $linkedin
     * @return GlUser
     */
    public function setLinkedin(string $linkedin): GlUser
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    /**
     * @return string
     */
    public function getTwitter(): string
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     * @return GlUser
     */
    public function setTwitter(string $twitter): GlUser
    {
        $this->twitter = $twitter;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl(): string
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     * @return GlUser
     */
    public function setWebsiteUrl(string $websiteUrl): GlUser
    {
        $this->websiteUrl = $websiteUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganization(): string
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     * @return GlUser
     */
    public function setOrganization(string $organization): GlUser
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return string
     */
    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    /**
     * @param string $jobTitle
     * @return GlUser
     */
    public function setJobTitle(string $jobTitle): GlUser
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPronouns(): ?string
    {
        return $this->pronouns;
    }

    /**
     * @param string|null $pronouns
     * @return GlUser
     */
    public function setPronouns(?string $pronouns): GlUser
    {
        $this->pronouns = $pronouns;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->bot;
    }

    /**
     * @param bool $bot
     * @return GlUser
     */
    public function setBot(bool $bot): GlUser
    {
        $this->bot = $bot;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWorkInformation(): ?string
    {
        return $this->workInformation;
    }

    /**
     * @param string|null $workInformation
     * @return GlUser
     */
    public function setWorkInformation(?string $workInformation): GlUser
    {
        $this->workInformation = $workInformation;
        return $this;
    }

    /**
     * @return int
     */
    public function getFollowers(): int
    {
        return $this->followers;
    }

    /**
     * @param int $followers
     * @return GlUser
     */
    public function setFollowers(int $followers): GlUser
    {
        $this->followers = $followers;
        return $this;
    }

    /**
     * @return int
     */
    public function getFollowing(): int
    {
        return $this->following;
    }

    /**
     * @param int $following
     * @return GlUser
     */
    public function setFollowing(int $following): GlUser
    {
        $this->following = $following;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocalTime(): string
    {
        return $this->localTime;
    }

    /**
     * @param string $localTime
     * @return GlUser
     */
    public function setLocalTime(string $localTime): GlUser
    {
        $this->localTime = $localTime;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getLastSignInAt(): \DateTimeInterface
    {
        return $this->lastSignInAt;
    }

    /**
     * @param \DateTimeInterface $lastSignInAt
     * @return GlUser
     */
    public function setLastSignInAt(\DateTimeInterface $lastSignInAt): GlUser
    {
        $this->lastSignInAt = $lastSignInAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getConfirmedAt(): \DateTimeInterface
    {
        return $this->confirmedAt;
    }

    /**
     * @param \DateTimeInterface $confirmedAt
     * @return GlUser
     */
    public function setConfirmedAt(\DateTimeInterface $confirmedAt): GlUser
    {
        $this->confirmedAt = $confirmedAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getLastActivityOn(): \DateTimeInterface
    {
        return $this->lastActivityOn;
    }

    /**
     * @param \DateTimeInterface $lastActivityOn
     * @return GlUser
     */
    public function setLastActivityOn(\DateTimeInterface $lastActivityOn): GlUser
    {
        $this->lastActivityOn = $lastActivityOn;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return GlUser
     */
    public function setEmail(string $email): GlUser
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getThemeId(): int
    {
        return $this->themeId;
    }

    /**
     * @param int $themeId
     * @return GlUser
     */
    public function setThemeId(int $themeId): GlUser
    {
        $this->themeId = $themeId;
        return $this;
    }

    /**
     * @return int
     */
    public function getColorSchemeId(): int
    {
        return $this->colorSchemeId;
    }

    /**
     * @param int $colorSchemeId
     * @return GlUser
     */
    public function setColorSchemeId(int $colorSchemeId): GlUser
    {
        $this->colorSchemeId = $colorSchemeId;
        return $this;
    }

    /**
     * @return int
     */
    public function getProjectsLimit(): int
    {
        return $this->projectsLimit;
    }

    /**
     * @param int $projectsLimit
     * @return GlUser
     */
    public function setProjectsLimit(int $projectsLimit): GlUser
    {
        $this->projectsLimit = $projectsLimit;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCurrentSignInAt(): \DateTimeInterface
    {
        return $this->currentSignInAt;
    }

    /**
     * @param \DateTimeInterface $currentSignInAt
     * @return GlUser
     */
    public function setCurrentSignInAt(\DateTimeInterface $currentSignInAt): GlUser
    {
        $this->currentSignInAt = $currentSignInAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCanCreateGroup(): bool
    {
        return $this->canCreateGroup;
    }

    /**
     * @param bool $canCreateGroup
     * @return GlUser
     */
    public function setCanCreateGroup(bool $canCreateGroup): GlUser
    {
        $this->canCreateGroup = $canCreateGroup;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCanCreateProject(): bool
    {
        return $this->canCreateProject;
    }

    /**
     * @param bool $canCreateProject
     * @return GlUser
     */
    public function setCanCreateProject(bool $canCreateProject): GlUser
    {
        $this->canCreateProject = $canCreateProject;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTwoFactorEnabled(): bool
    {
        return $this->twoFactorEnabled;
    }

    /**
     * @param bool $twoFactorEnabled
     * @return GlUser
     */
    public function setTwoFactorEnabled(bool $twoFactorEnabled): GlUser
    {
        $this->twoFactorEnabled = $twoFactorEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->external;
    }

    /**
     * @param bool $external
     * @return GlUser
     */
    public function setExternal(bool $external): GlUser
    {
        $this->external = $external;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrivateProfile(): bool
    {
        return $this->privateProfile;
    }

    /**
     * @param bool $privateProfile
     * @return GlUser
     */
    public function setPrivateProfile(bool $privateProfile): GlUser
    {
        $this->privateProfile = $privateProfile;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommitEmail(): string
    {
        return $this->commitEmail;
    }

    /**
     * @param string $commitEmail
     * @return GlUser
     */
    public function setCommitEmail(string $commitEmail): GlUser
    {
        $this->commitEmail = $commitEmail;
        return $this;
    }
}
